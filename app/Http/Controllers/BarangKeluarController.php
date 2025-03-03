<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangKeluarRequest;
use App\Models\BarangKeluarModel;
use App\Models\BarangMasuk\kategori;
use App\Models\BarangMasukModel;
use App\Models\Order;
use App\Models\RekapModel;
use App\Models\StokGudangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangkeluar = BarangKeluarModel::where('pop', Auth::user()->pop)->get();
        return view('Tabelview.Tabelbarangkeluar', ['barangkeluar' => $barangkeluar]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangmasuk = BarangMasukModel::where('pop', Auth::user()->pop)->get();
        $kategoris = kategori::where('pop', Auth::user()->pop)->get();
        $order = Order::where('pop', Auth::user()->pop)->get();
        return view('Inputview.inputbarangkeluar', ['kategoris' => $kategoris, 'barangmasuk' => $barangmasuk, 'order' => $order]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BarangKeluarRequest $request)
    {
        $jumlaharray = $request->input('jumlah');
        $id = $request->input('id');
        $qr_code = $request->input('qr_code');
        $output_by = Auth::user()->username;

        foreach ($jumlaharray as $id => $jumlah) {

            $barangMasuk = BarangMasukModel::find($id);
            $nama_customer = $request->input('ID') . '_' . $request->input('namacustomer'); // Cari barang berdasarkan ID
            $qr_code_value = isset($qr_code[$id]) ? $qr_code[$id] : null; // Ambil qr_code yang sesuai dengan ID

            $exists = BarangKeluarModel::where('id', $id)
                ->where('qr_code', $qr_code_value)
                ->where('pop', Auth::user()->pop) // Memeriksa pop juga
                ->exists();

            if ($exists) {
                // Jika kombinasi ID dan QR Code sudah ada, tampilkan error
                return redirect()->back()->with('error', 'Barang sudah tercatat sebagai barang yang telah dikeluarkan.');
            }

            // Simpan data ke database untuk setiap barang
            BarangKeluarModel::create([
                'id' => $id,
                'kode_barang' => $barangMasuk->kode_barang,
                'kategori' => $barangMasuk->kategori,
                'nama_barang' => $barangMasuk->nama_barang,
                'seri' => $barangMasuk->seri,
                'jumlah' => $jumlah,  // Jumlah dari input
                'lokasi' => $request->input('lokasi'),
                'foto' => $barangMasuk->foto,
                'nama_customer' => $nama_customer,
                'output_by' => $output_by,
                'keterangan' => $request->input('keterangan'),
                'pop' => Auth::user()->pop,
                'qr_code' => $qr_code_value,  // Gunakan qr_code yang sesuai
            ]);

            // Hapus order berdasarkan qr_code
            if ($qr_code_value) {
                Order::where('qr_code', $qr_code_value)->delete();
            }


            if ($barangMasuk->satuan == 'pack' || $barangMasuk->satuan == 'roll') {
                $barangMasuk->hasil = $barangMasuk->hasil - $jumlah;
                $roll = $barangMasuk->hasil / $barangMasuk->rasio;
                $nilaiGenap = ceil($roll);
                $barangMasuk->jumlah = $nilaiGenap;
                $barangMasuk->detail_jumlah = $barangMasuk->hasil % $barangMasuk->rasio;
                $barangMasuk->save();


                // Update tabel stok_gudang
                $stokGudang = StokGudangModel::where('id', $id)->first();
                if ($stokGudang) {
                    $stokGudang->jumlah = $barangMasuk->jumlah; // Update jumlah dengan penambahan
                    // Atur satuan dari barang masuk
                    $stokGudang->detail_jumlah = $barangMasuk->detail_jumlah; // Atur rasio // Keterangan
                    $stokGudang->hasil = $barangMasuk->hasil;
                    $stokGudang->save();
                }

                $rekap = RekapModel::where('id', $id)->first();
                if ($rekap) {
                    $rekap->jumlah = $barangMasuk->jumlah; // Update jumlah dengan penambahan
                    // Atur satuan dari barang masuk
                    $rekap->detail_jumlah = $barangMasuk->detail_jumlah; // Atur rasio // Keterangan
                    $rekap->hasil = $barangMasuk->hasil;
                    $rekap->out += $jumlah;
                    $rekap->save();
                }

                if ($barangMasuk->hasil === 0) {
                    $barangMasuk->delete();
                }
            }

            if ($barangMasuk->satuan == 'pcs' || $barangMasuk->satuan == 'meter' || $barangMasuk->satuan == 'unit') {
                $barangMasuk->jumlah -= $jumlah;
                $barangMasuk->save();

                $stokGudang = StokGudangModel::where('id', $id)->first();
                if ($stokGudang) {
                    $stokGudang->jumlah = $barangMasuk->jumlah; // Update jumlah dengan penambahan
                    $stokGudang->save();
                }

                $rekap = RekapModel::where('id', $id)->first();
                if ($rekap) {
                    $rekap->jumlah = $barangMasuk->jumlah;
                    $rekap->out += $jumlah; // Update jumlah dengan penambahan
                    $rekap->save();
                }

                if ($barangMasuk->jumlah === 0) {
                    $barangMasuk->delete();
                }
            }
        }
        return redirect()->route('input_barang_keluar')->with([
            'success' => 'Data Berhasil Diorder!'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = DB::table('barang_keluar')
            ->where('pop', Auth::user()->pop);

        // Filter berdasarkan kategori, nama barang, dan seri
        if ($request->namabarang) {
            $query->where('nama_barang', 'like', '%' . $request->namabarang . '%');
        }
        if ($request->seri) {
            $query->where('seri', 'like', '%' . $request->seri . '%');
        }
        if ($request->nama_customer) {
            $query->where('nama_customer', 'like', '%' . $request->nama_customer . '%');
        }
        if ($request->id) {
            // Memisahkan id dan qr_code
            $parts = explode('-', $request->id);

            if (count($parts) == 2) {
                $id = $parts[0];
                $qr_code = $parts[1];

                $query->where('id', $id)
                    ->where('qr_code', $qr_code);
            } else {
                // Jika format ID tidak sesuai
                return redirect()->back()->with('error', 'Format ID tidak valid');
            }
        }

        $results = $query->get();

        return response()->json($results);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $nama_barang, $nama_customer, $output_by)
    {
        // Cari item berdasarkan ID, nama_barang, nama_customer, dan output_by
        BarangKeluarModel::where('id', $id)
            ->where('nama_barang', $nama_barang)
            ->where('nama_customer', $nama_customer)
            ->where('output_by', $output_by)
            ->delete();

        // Periksa apakah item ditemukan sebelum menghapu
        return redirect()->route('tabel_barang_keluar')->with(['success_hapus' => 'Data Berhasil Dihapus!']);
    }
}
