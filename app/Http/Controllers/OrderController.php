<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluarModel;
use App\Models\BarangMasukModel;
use App\Models\Order;
use App\Models\StokGudangModel;
use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
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


    public function store($id)
    {
        $barcodePart = explode('-', $id);
        $part1 = $barcodePart[0]; // Bagian pertama dari barcode (ID)
        $uniqueCode = $barcodePart[1];

        // Mencari barang berdasarkan 'pop' dan 'id' dari barcode
        $barangMasuk = StokGudangModel::where('pop', Auth::user()->pop)->where('id', $part1)->first();

        if (!$barangMasuk) {
            return redirect()->route('input_barang_keluar')->with('error', 'Barang tidak ditemukan');
        }

        if (($barangMasuk->satuan == 'roll' || $barangMasuk->satuan == 'pack') && Order::where('id', $barangMasuk->id)->exists()) {
            return redirect()->route('input_barang_keluar')->with('error', 'Barang sudah ditambahkan');
        }

        if (($barangMasuk->satuan == 'pcs' || $barangMasuk->satuan == 'unit') && Order::where('qr_code', $uniqueCode)->exists()) {
            return redirect()->route('input_barang_keluar')->with('error', 'Barang sudah ditambahkan');
        }

        // Menyimpan data order baru
        Order::create([
            'stok_gudang_id' => $barangMasuk->id,
            'username' => Auth::user()->username,
            'pop' => Auth::user()->pop,
            'qr_code' => $uniqueCode,
        ]);

        // Pengarahan setelah sukses
        return redirect()->route('input_barang_keluar')->with('success', 'Barang berhasil ditambahkan');
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
        Order::where('qr_code', $id)->delete();
        return redirect()->route('input_barang_keluar');
    }
}
