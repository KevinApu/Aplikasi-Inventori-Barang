<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Milon\Barcode\DNS1D;

class StokGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Tabelview.Tabelstokgudang');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = DB::table('stok_gudang')
        ->where('pop', Auth::user()->KLUser->KLModel->pop);

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
    public function destroy(string $id)
    {
        //
    }
}
