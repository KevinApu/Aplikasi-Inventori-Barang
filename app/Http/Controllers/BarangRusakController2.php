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
    public function store(Request $request, $id)
    {
        $input_by = Auth::user()->username;
        $foto = $request->file('foto');
        $finalFileName = time() . '-' . $foto->hashName();
        $foto->storeAs('public/img', $finalFileName);

        $barangKeluar = BarangKeluarModel::where('id', $id)->first();

        BarangRusakModel::create([
            'jumlah' => $request->input('jumlah'),
            'foto' => 'img/' . $finalFileName,
            'input_by' => $input_by,
            'kondisi' => $request->input('kondisi'),
            'penyebab' => $request->input('penyebab'),
            'pop' => Auth::user()->pop,
            'qr_code' => $barangKeluar->qr_code,
            'status' => 'rusak_sesudah_penggunaan',
            'stok_gudang_id' => $barangKeluar->stok_gudang_id,
        ]);

        $barangKeluar->jumlah = $barangKeluar->_jumlah - $request->input('jumlah');
        $barangKeluar->save();

        if ($barangKeluar->jumlah <= 0) {
            $barangKeluar->delete();
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
