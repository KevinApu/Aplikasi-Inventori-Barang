<?php

namespace App\Http\Controllers;

use App\Models\RequestBarangModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestBarangController extends Controller
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
        $pop = Auth::user()->KLModel->pop;
        $result = RequestBarangModel::where('pop', $pop)
            ->whereIn('status', ['Menunggu Pengiriman', 'Sedang Dikirim'])
            ->get();
        if ($result->isNotEmpty()) {
            $riwayat = RequestBarangModel::where('pop', $pop)->first();

            if ($riwayat) {
                $riwayat->formatted_created_at = Carbon::parse($riwayat->created_at)->format('d M Y, H:i');

                if ($riwayat->status == 'Sedang Dikirim') {
                    $riwayat->formatted_updated_at = Carbon::parse($riwayat->updated_at)->format('d M Y, H:i');
                }

                $riwayat->formatted_tanggal_terima = $riwayat->tanggal_terima
                    ? Carbon::parse($riwayat->tanggal_terima)->format('d M Y, H:i')
                    : null;

                $riwayat->formatted_tanggal_estimasi = $riwayat->tanggal_estimasi
                    ? Carbon::parse($riwayat->tanggal_estimasi)->format('d M Y, H:i')
                    : null;
            }
        } else {
            $riwayat = null;
        }

        return view('Inputview.RequestBarang', compact('result', 'riwayat'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pop = Auth::user()->KLModel->pop;

        if (RequestBarangModel::where('pop', $pop)->where('status', 'Tolak')->exists()) {
            return redirect()->back()->with('error', 'Tidak dapat menginputkan data karena ada permintaan yang ditolak untuk lokasi ini saat ini.');
        }
        if (RequestBarangModel::where('pop', $pop)->where('status', 'Pending')->exists()) {
            return redirect()->back()->with('error', 'Tidak dapat mengajukan permintaan baru karena ada permintaan yang masih pending untuk lokasi ini.');
        }

        $hasApproved = RequestBarangModel::where('pop', $pop)
            ->where('status', 'Setujui')
            ->exists();

        if ($hasApproved) {
            RequestBarangModel::where('pop', $pop)
                ->update(['status' => 'Pending']);
        }

        foreach ($request->nama_barang as $index => $nama) {
            RequestBarangModel::create([
                'pop' => $pop,
                'nama_pengaju' => Auth::user()->username,
                'nama_barang' => $nama,
                'seri' => $request->seri[$index],
                'jumlah' => $request->jumlah[$index],
                'catatan' => $request->keterangan[$index]
            ]);
        }
        return redirect()->back()->with('success', 'Data berhasil diinput.');
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


    // public function resetrequestbarang(Request $request){
    //     RequestBarangModel::where('status', 'Dikirim')->delete();
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update($pop)
    {
        RequestBarangModel::where('pop', $pop)->delete();
        return redirect()->back()->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
