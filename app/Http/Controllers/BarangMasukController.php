<?php

namespace App\Http\Controllers;

use App\Enums\satuan;
use App\Http\Controllers\Controller;
use App\Http\Requests\BarangMasukRequest;
use App\Models\BarangMasuk\kategori;
use App\Models\BarangMasuk\nama_barang;
use App\Models\BarangMasukModel;
use App\Models\Order;
use App\Models\RekapModel;
use App\Models\StokGudangModel;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BarangMasukController extends Controller
{

    public function index()
    {
        $barangmasuk = BarangMasukModel::where('pop', Auth::user()->pop)->get();
        return view('Tabelview.Tabelbarangmasuk', ['barangmasuk' => $barangmasuk]);
    }


    public function kategori(Request $request)
    {

        $request->validate([
            'kategori_baru' => [
                'required',
                Rule::unique('kategori', 'kategori')->where('pop', Auth::user()->pop),
            ],
        ], [
            'kategori_baru.required' => 'Kategori wajib diisi',
            'kategori_baru.unique' => 'Kategori ini sudah ada untuk POP Anda',
        ]);

        kategori::create([
            'kategori' => $request->input('kategori_baru'),
            'pop' => Auth::user()->pop
        ]);
        return redirect()->route('input_barang_masuk');
    }


    public function namabarang(Request $request)
    {
        $request->validate([
            'namabarang_baru' => [
                'required',
                Rule::unique('nama_barang', 'nama_barang')->where('pop', Auth::user()->pop),
            ],
        ], [
            'namabarang_baru.required' => 'Nama barang wajib diisi',
            'namabarang_baru.unique' => 'Nama barang ini sudah ada untuk POP Anda',
        ]);


        // Jika validasi berhasil, simpan data
        nama_barang::create([
            'nama_barang' => $request['namabarang_baru'],
            'pop' => Auth::user()->pop
        ]);
        return redirect()->route('input_barang_masuk');
    }


    public function create()
    {
        $kategoris = kategori::where('pop', Auth::user()->pop)->get();
        $namabarang = nama_barang::where('pop', Auth::user()->pop)->get();
        $stokGudang = StokGudangModel::where('pop', Auth::user()->pop)->get();

        return view('Inputview.inputbarangmasuk', ['kategoris' => $kategoris, 'nama_barang' => $namabarang, 'stokGudang' => $stokGudang]);
    }

    public function store(BarangMasukRequest $request): RedirectResponse
    {
        $inputby = Auth::user()->username;
        $foto = $request->file('foto');
        $finalFileName = time() . '-' . $foto->hashName();
        $foto->storeAs('public/img', $finalFileName);
    
        $barangMasukData = $this->prepareBarangData($request, $inputby, $finalFileName);
    
        // Validasi di BarangMasukModel
        $existsInBarangMasuk = BarangMasukModel::whereRaw("REPLACE(LOWER(kode_barang), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->kodebarang))])
            ->whereRaw("REPLACE(LOWER(nama_barang), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->namabarang))])
            ->whereRaw("REPLACE(LOWER(kategori), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->kategori))])
            ->whereRaw("REPLACE(LOWER(seri), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->seri))])
            ->where('pop', Auth::user()->pop) // Menambahkan pengecekan 'pop' yang sedang login
            ->first();
    
        // Validasi di RekapModel
        $existsInRekap = RekapModel::whereRaw("REPLACE(LOWER(kode_barang), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->kodebarang))])
            ->whereRaw("REPLACE(LOWER(nama_barang), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->namabarang))])
            ->whereRaw("REPLACE(LOWER(kategori), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->kategori))])
            ->whereRaw("REPLACE(LOWER(seri), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->seri))])
            ->where('pop', Auth::user()->pop) // Menambahkan pengecekan 'pop' yang sedang login
            ->first();
    
        // Jika barang sudah ada di salah satu tabel
        if ($existsInBarangMasuk || $existsInRekap) {
            return redirect()->back()->with('error', 'Data sudah ada di sistem.');
        }
    
        // Lanjutkan proses jika validasi lolos
        $this->handleNewStok($request, $barangMasukData);
    
        return redirect()->route('input_barang_masuk')->with([
            'success' => 'Barang berhasil ditambahkan!',
            'barang' => [
                'nama' => $barangMasukData['nama_barang'],
                'spesifikasi' => $barangMasukData['kategori'] . ', ' . $barangMasukData['seri'],
                'foto' => $barangMasukData['foto'],
            ],
        ]);
    }
    
    private function prepareBarangData($request, $inputby, $finalFileName)
    {
        $data = [
            'kode_barang' => $request->kodebarang,
            'kategori' => $request->kategori,
            'nama_barang' => $request->namabarang,
            'seri' => $request->seri,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'lokasi' => $request->lokasi,
            'foto' => 'img/' . $finalFileName,
            'input_by' => $inputby,
            'keterangan' => $request->keterangan,
            'pop' => Auth::user()->pop,
            'created_at' => $request->tglmasuk . ' ' . now()->format('H:i:s'),
            'updated_at' => $request->tglmasuk . ' ' . now()->format('H:i:s'),
        ];
    
        if (in_array($request->satuan, ['Roll', 'Pack'])) {
            $data['rasio'] = $request->rasio;
            $data['hasil'] = $request->jumlah * $request->rasio;
            $data['detail_jumlah'] = $data['hasil'] % $request->rasio;
        }
    
        return $data;
    }
    
    private function handleNewStok($request, $barangMasukData)
    {
        // Menambahkan pengecekan 'pop' di query
        $exists = StokGudangModel::whereRaw("REPLACE(LOWER(kode_barang), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->kodebarang))])
            ->whereRaw("REPLACE(LOWER(nama_barang), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->namabarang))])
            ->whereRaw("REPLACE(LOWER(kategori), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->kategori))])
            ->whereRaw("REPLACE(LOWER(seri), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->seri))])
            ->where('pop', Auth::user()->pop)  // Menambahkan pengecekan 'pop' yang sedang login
            ->first();
    
        if ($exists) {
            // Jika data sudah ada, perbarui stok dan simpan foto baru jika ada perubahan foto
            $foto = $request->file('foto');
            $finalFileName = time() . '-' . $foto->hashName();
    
            // Hapus foto lama jika ada
            if (!empty($exists->foto)) {
                Storage::delete('public/' . $exists->foto);
            }
    
            // Simpan foto baru
            $foto->storeAs('public/img', $finalFileName);
    
            $barangMasukData['created_at'] = $exists->created_at;
    
            // Update data barang di StokGudangModel
            StokGudangModel::where('id', $exists->id)->update($barangMasukData);
    
            // Simpan ke BarangMasukModel dan RekapModel
            BarangMasukModel::create(['id' => $exists->id] + $barangMasukData);
            RekapModel::create(['id' => $exists->id, 'stok_awal' => $barangMasukData['hasil'] ?? $barangMasukData['jumlah']] + $barangMasukData);
        } else {
            // Jika data belum ada, buat data baru di semua model terkait
            $barangMasuk = BarangMasukModel::create($barangMasukData);
            RekapModel::create(['id' => $barangMasuk->id, 'stok_awal' => $barangMasukData['hasil'] ?? $barangMasukData['jumlah']] + $barangMasukData);
            StokGudangModel::create(['id' => $barangMasuk->id] + $barangMasukData);
        }
    }
    






    public function show(Request $request)
    {
        $query = DB::table('barang_masuk')
            ->where('pop', Auth::user()->pop);

        // Filter berdasarkan kategori, nama barang, dan seri
        if ($request->kategori) {
            $query->where('kategori', 'like', '%' . $request->kategori . '%');
        }
        if ($request->namabarang) {
            $query->where('nama_barang', 'like', '%' . $request->namabarang . '%');
        }
        if ($request->seri) {
            $query->where('seri', 'like', '%' . $request->seri . '%');
        }
        if ($request->tahun) {
            $query->whereYear('created_at', $request->tahun);
        }
        if ($request->bulan) {
            $query->whereMonth('created_at', $request->bulan);
        }
        if ($request->id) {
            // Memisahkan id dan qr_code
            $parts = explode('-', $request->id);
            $id = $parts[0];
            $query->where('id', $id);
        }

        $results = $query->get();
        session(['barangMasukData' => $results]);

        return response()->json($results);
    }


    public function barcode(Request $request)
    {
        $barcode = $request->barcode;
        $item = DB::table('stok_gudang')
            ->where('id', $barcode)
            ->where('pop', Auth::user()->pop)
            ->first();
        return response()->json($item);
    }




    public function edit(string $id)
    {
        // Logika untuk menampilkan form edit barang
    }


    public function update(Request $request, string $id)
    {
        // Logika untuk memperbarui barang
        $barangMasuk = BarangMasukModel::findOrFail($id);

        if ($request->hasFile('foto')) {
            //upload new image
            $foto = $request->foto;
            $finalFileName = time() . '-' . $foto->hashName();

            if (!empty($barangMasuk->foto)) {
                Storage::delete('public/' . $barangMasuk->foto);
            }
            // Simpan foto baru
            $foto->storeAs('public/img', $finalFileName);

            //delete old image
            Storage::disk('public')->delete($barangMasuk->foto);

            BarangMasukModel::where('id', $id)->update([
                'foto' => 'img/' . $finalFileName,
                'kode_barang'         => $request->kodebarang,
                'nama_barang'   => $request->namabarang,
                'seri'         => $request->seri,
                'lokasi'         => $request->lokasi,
                'keterangan'         => $request->keterangan
            ]);
            StokGudangModel::where('id', $id)->update([
                'foto' => 'img/' . $finalFileName,
                'kode_barang'         => $request->kodebarang,
                'nama_barang'   => $request->namabarang,
                'seri'         => $request->seri,
                'lokasi'         => $request->lokasi,
                'keterangan'         => $request->keterangan
            ]);
        } else {

            BarangMasukModel::where('id', $id)->update([
                'kode_barang'         => $request->kodebarang,
                'nama_barang'   => $request->namabarang,
                'seri'         => $request->seri,
                'lokasi'         => $request->lokasi,
                'keterangan'         => $request->keterangan
            ]);
            StokGudangModel::where('id', $id)->update([
                'kode_barang'         => $request->kodebarang,
                'nama_barang'   => $request->namabarang,
                'seri'         => $request->seri,
                'lokasi'         => $request->lokasi,
                'keterangan'         => $request->keterangan
            ]);
            RekapModel::where('id', $id)->update([
                'kode_barang'         => $request->kodebarang,
                'nama_barang'   => $request->namabarang,
                'seri'         => $request->seri,
            ]);
        }
        return redirect()->route('tabel_barang_masuk')->with([
            'success_update' => 'Barang berhasil diupdate!',
        ]);
    }



    public function penambahan_stok(Request $request, string $id)
    {
        $barangMasuk = BarangMasukModel::findOrFail($id);

        if ($barangMasuk->satuan == 'pack' || $barangMasuk->satuan == 'roll') {
            // Hitung hasil stok awal
            $totalHasil = $barangMasuk->hasil;

            // Tambahkan stok baru ke hasil
            $totalHasil += $request->input('jumlah') * $barangMasuk->rasio;

            $roll = $totalHasil / $barangMasuk->rasio;
            $barangMasuk->jumlah = ceil($roll);
            // Hitung jumlah pack/roll dan sisa detail
            $barangMasuk->detail_jumlah = $totalHasil % $barangMasuk->rasio;

            // Simpan perubahan
            $barangMasuk->hasil = $totalHasil;
            $barangMasuk->save();


            $rekap = RekapModel::firstOrNew(['id' => $barangMasuk->id]);
            $rekap->jumlah = $barangMasuk->jumlah; // Update jumlah dengan penambahan
            // Atur satuan dari barang masuk
            $rekap->detail_jumlah = $barangMasuk->detail_jumlah; // Atur rasio // Keterangan
            $rekap->hasil = $barangMasuk->hasil; // Atur rasio // Keterangan

            $total = $request->input('jumlah') * $barangMasuk->rasio;
            $rekap->in += $total;    // Atur rasio // Keterangan      
            $rekap->save();
        } else {
            // Jika bukan pack atau roll, langsung tambahkan jumlah
            $barangMasuk->jumlah += $request->input('jumlah');
            $barangMasuk->save();


            $rekap = RekapModel::firstOrNew(['id' => $barangMasuk->id]);
            $rekap->jumlah = $barangMasuk->jumlah; // Update jumlah dengan penambahan
            // Atur satuan dari barang masuk
            $rekap->detail_jumlah = $barangMasuk->detail_jumlah; // Atur rasio // Keterangan
            $rekap->hasil = $barangMasuk->hasil; // Atur rasio // Keterangan

            $rekap->in += $request->input('jumlah');    // Atur rasio // Keterangan      
            $rekap->save();
        }


        $stokGudang = StokGudangModel::firstOrNew(['id' => $barangMasuk->id]);
        $stokGudang->jumlah = $barangMasuk->jumlah; // Update jumlah dengan penambahan
        // Atur satuan dari barang masuk
        $stokGudang->detail_jumlah = $barangMasuk->detail_jumlah; // Atur rasio // Keterangan
        $stokGudang->hasil = $barangMasuk->hasil; // Atur rasio // Keterangan
        $stokGudang->save();

        return redirect()->route('tabel_barang_masuk')->with([
            'success_addstock' => 'Jumlah Barang berhasil ditambah!',
        ]);
    }




    public function destroy(string $id)
    {
        // Logika untuk menghapus barang
        //get product by ID
        $product = BarangMasukModel::findOrFail($id);
        //delete product
        $product->delete();

        $rekap = RekapModel::findOrFail($id);
        $rekap->delete();

        Order::where('id', $id)->delete();
        // Cari stok gudang berdasarkan ID
        $stokGudang = StokGudangModel::findOrFail($id); // Menggunakan findOrFail untuk mendapatkan model
        // Atur kode_barang
        $stokGudang->jumlah = 0;
        $stokGudang->detail_jumlah = null;
        $stokGudang->hasil = null;
        $stokGudang->rasio = null;

        // Simpan perubahan ke database
        $stokGudang->save();

        return redirect()->route('tabel_barang_masuk')->with([
            'success_hapus' => 'Barang berhasil dihapus!',
        ]);
    }
}
