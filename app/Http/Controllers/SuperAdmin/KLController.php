<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\KLRequest;
use App\Models\KLModel;
use App\Models\KLUsers;
use App\Models\Login;
use App\Models\PengirimanModel;
use App\Models\RequestBarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kantorlayanan = KLModel::get();
        return view('SuperAdmin.Tabelbarangmasuk', ['kantorlayanan' => $kantorlayanan]);
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
    public function store(KLRequest $request)
    {
        KLModel::create([
            'pop' => $request->kodepop,
            'lokasi' => $request->lokasikantor,
            'alamat' => $request->alamatkantor,
        ]);

        return redirect()->back()
            ->with('success', 'Penambahan Kantor berhasil dilakukan!')
            ->with('activeTab', 'tambahcabang');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = DB::table('stok_gudang');

        if ($request->pop) {
            $query->where('pop', 'like', '%' . $request->pop . '%');
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
    public function update(Request $request, $pop)
    {
        KLModel::where('pop', $pop)->update([
            'lokasi' => $request->lokasi,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()
            ->with('success', 'Penggantian data Kantor berhasil dilakukan!')
            ->with('activeTab', 'daftarcabang');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $pop)
    {

        $pengirimanTerkait = PengirimanModel::where('tujuan', $pop)->exists();

        if ($pengirimanTerkait) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus! Masih ada pengiriman terkait dengan kantor ini.')
                ->with('activeTab', 'daftarcabang');
        }

        $kantorlayanan = KLModel::find($pop);
        $kantorlayanan->delete();
        return redirect()->back()
            ->with('success', 'Penghapusan Kantor beserta user terkait berhasil dilakukan!')
            ->with('activeTab', 'daftarcabang');
    }
}
