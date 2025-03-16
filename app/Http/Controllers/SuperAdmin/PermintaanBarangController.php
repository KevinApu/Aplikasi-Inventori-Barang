<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\RequestBarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermintaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $daftarpermintaan = RequestBarangModel::whereNotIn('status', ['Menunggu Pengiriman', 'Sedang Dikirim'])
        ->with('KLModel')
        ->get();
        return view('SuperAdmin.Request', ['daftarpermintaan' => $daftarpermintaan]);
    }

    /**
     * Show the form for creating a new resource.
     */

    // Controller
    public function setujuiMultiple(Request $request)
    {
        $ids = $request->input('ids');
        RequestBarangModel::whereIn('id', $ids)
            ->update([
                'status' => 'Setujui',
                'ket_status' => NULL,
                'updated_at' => now()
            ]);
        return response()->json(['message' => 'Semua permintaan telah disetujui.']);
    }

    public function tolakMultiple(Request $request)
    {
        $ids = $request->input('ids');
        $statusNote = $request->input('statusNote');
        RequestBarangModel::whereIn('id', $ids)
            ->update([
                'status' => 'Tolak',
                'ket_status' => $statusNote,
                'updated_at' => now(),
            ]);
        return response()->json(['message' => 'Semua permintaan telah ditolak.']);
    }






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
