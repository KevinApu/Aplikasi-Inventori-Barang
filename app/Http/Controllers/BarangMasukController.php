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
        $barangmasuk = StokGudangModel::where('pop', Auth::user()->pop)->get();
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

        return view('Inputview.inputbarangmasuk', ['kategoris' => $kategoris, 'nama_barang' => $namabarang]);
    }

    public function store(BarangMasukRequest $request): RedirectResponse
    {
        $inputby = Auth::user()->username;
        $foto = $request->file('foto');
        $finalFileName = time() . '-' . $foto->hashName();
        $foto->storeAs('public/img', $finalFileName);

    

        $barangMasukData = $this->prepareBarangData($request, $inputby, $finalFileName);

        $existsInStokGudang = StokGudangModel::whereRaw("REPLACE(LOWER(kode_barang), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->kodebarang))])
            ->whereRaw("REPLACE(LOWER(nama_barang), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->namabarang))])
            ->whereRaw("REPLACE(LOWER(kategori), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->kategori))])
            ->whereRaw("REPLACE(LOWER(seri), ' ', '') = ?", [strtolower(str_replace(' ', '', $request->seri))])
            ->where('pop', Auth::user()->pop)
            ->first();

        // Jika barang sudah ada di BarangMasuk dan jumlahnya 0, maka update jumlah dan satuan
        if ($existsInStokGudang && $existsInStokGudang->jumlah == 0) {
            $updateData = ['jumlah' => $request->jumlah];

            // Jika satuannya Roll atau Pack, tambahkan perhitungan rasio
            if (in_array($request->satuan, ['Roll', 'Pack'])) {
                $updateData['rasio'] = $request->rasio;
                $updateData['hasil'] = $request->jumlah * $request->rasio;
                $updateData['detail_jumlah'] = $updateData['hasil'] % $request->rasio;
            }

            $existsInStokGudang->update($updateData);
            return redirect()->back()->with('success', 'Jumlah barang di BarangMasuk berhasil diperbarui.');
        }

        // Jika barang sudah ada di salah satu tabel
        if ($existsInStokGudang) {
            return redirect()->back()->with('error', 'Data sudah ada di sistem.');
        }

        // Lanjutkan proses jika validasi lolos
        $this->handleNewStok($barangMasukData);

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

    private function handleNewStok($barangMasukData)
    {
        $stokGudangModel = StokGudangModel::create($barangMasukData);
        RekapModel::create([
            'stok_gudang_id' => $stokGudangModel->id,
            'stok_awal' => isset($barangMasukData['hasil']) ? $barangMasukData['hasil'] : $barangMasukData['jumlah'],
            'in' => 0, // Default nilai masuk
            'out' => 0, // Default nilai keluar
            'pop' => Auth::user()->pop,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }







    public function show(Request $request)
    {
        $query = DB::table('stok_gudang')
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
        $StokGudangModel = StokGudangModel::findOrFail($id);
        $data = $request->only(['kodebarang', 'namabarang', 'seri', 'lokasi', 'keterangan']);

        // Jika ada file foto baru
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $finalFileName = time() . '-' . $foto->hashName();

            // Hapus foto lama jika ada
            if (!empty($StokGudangModel->foto)) {
                Storage::delete('public/' . $StokGudangModel->foto);
            }

            // Simpan foto baru
            $foto->storeAs('public/img', $finalFileName);
            $data['foto'] = 'img/' . $finalFileName;
        }

        // Update data
        $StokGudangModel->update([
            'kode_barang' => $data['kodebarang'],
            'nama_barang' => $data['namabarang'],
            'seri'        => $data['seri'],
            'lokasi'      => $data['lokasi'],
            'keterangan'  => $data['keterangan'],
            'foto'        => $data['foto'] ?? $StokGudangModel->foto, // Gunakan foto lama jika tidak ada perubahan
        ]);

        return redirect()->route('tabel_barang_masuk')->with('success_update', 'Barang berhasil diupdate!');
    }



    public function penambahan_stok(Request $request, string $id)
    {
        $StokGudangModel = StokGudangModel::findOrFail($id);
        $jumlahBaru = $request->input('jumlah');
    
        if (in_array($StokGudangModel->satuan, ['pack', 'roll'])) {
            $totalHasil = $StokGudangModel->hasil + ($jumlahBaru * $StokGudangModel->rasio);
            $StokGudangModel->jumlah = ceil($totalHasil / $StokGudangModel->rasio);
            $StokGudangModel->detail_jumlah = $totalHasil % $StokGudangModel->rasio;
            $StokGudangModel->hasil = $totalHasil;
        } else {
            $StokGudangModel->jumlah += $jumlahBaru;
        }
        $StokGudangModel->save();
    
        // Update RekapModel
        $rekap = RekapModel::firstOrNew(['stok_gudang_id' => $StokGudangModel->id]);
        $rekap->in += $jumlahBaru * ($StokGudangModel->rasio ?? 1);
        $rekap->save();
    
        return redirect()->route('tabel_barang_masuk')->with('success_addstock', 'Jumlah Barang berhasil ditambah!');
    }    




    public function destroy(string $id)
    {
        //
    }
}
