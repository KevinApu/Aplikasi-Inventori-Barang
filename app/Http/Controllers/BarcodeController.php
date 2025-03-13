<?php

namespace App\Http\Controllers;

use Faker\Provider\Barcode;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function generate(Request $request)
    {
        // Ambil data dari request
        $kode_barang = $request->input('kode_barang');
        $nama_barang = $request->input('nama_barang');
        $seri = $request->input('seri');

        return view('barcode', compact('kode_barang', 'nama_barang', 'seri', 'barcode'));
    }
}
