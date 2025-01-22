<?php

namespace App\Http\Controllers;



use App\Models\BarangKeluarModel;
use App\Models\BarangMasukModel;
use App\Models\BarangRusakModel;
use App\Models\StokGudangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangRusakController2 extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id, $nama_customer, $output_by, $lokasi)
    {
        $input_by = Auth::user()->username;

        $foto = $request->file('foto'); // 'jpg'
        //format hashname database
        $finalFileName = time() . '-' . $foto->hashName();
        $foto->storeAs('public/img', $finalFileName);
        // Cari barang berdasarkan ID;
        $barangKeluar = BarangKeluarModel::where('id', $id)
            ->where('nama_customer', $nama_customer)
            ->where('output_by', $output_by)
            ->where('lokasi', $lokasi)
            ->first();


        // Simpan data ke database untuk setiap barang
        BarangRusakModel::create([
            'id' => $id,
            'kode_barang' => $barangKeluar->kode_barang,
            'kategori' => $barangKeluar->kategori,
            'nama_barang' => $barangKeluar->nama_barang,
            'seri' => $barangKeluar->seri,
            'jumlah' => $request->input('jumlah'),
            'foto' => 'img/' . $finalFileName,
            'input_by' => $input_by,
            'kondisi' => $request->input('kondisi'),
            'penyebab' => $request->input('penyebab'),
            'pop' => Auth::user()->pop,
            'qr_code' => $barangKeluar->qr_code,
            'status' => 'rusak_sesudah_penggunaan',
        ]);


        DB::table('barang_keluar')
            ->where('id', $id)
            ->where('nama_customer', $nama_customer)
            ->where('output_by', $output_by)
            ->where('lokasi', $lokasi)
            ->update(['jumlah' => $barangKeluar->jumlah - $request->input('jumlah')]);


        // Ambil ulang data setelah update
        $barangKeluar = DB::table('barang_keluar')
            ->where('id', $id)
            ->where('nama_customer', $nama_customer)
            ->where('output_by', $output_by)
            ->where('lokasi', $lokasi)
            ->first();

        // Pastikan jumlah sudah diperbarui dan lakukan pengecekan untuk penghapusan
        if ($barangKeluar->jumlah === 0) {
            DB::table('barang_keluar')
                ->where('id', $id)
                ->where('nama_customer', $nama_customer)
                ->where('output_by', $output_by)
                ->where('lokasi', $lokasi)
                ->delete();
        }

        return redirect()->route('tabel_barang_keluar')->with([
            'success_hapus' => 'Barang rusak berhasil diperbarui!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
