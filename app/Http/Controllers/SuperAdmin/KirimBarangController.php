<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KirimBarangRequest;
use App\Models\KLModel;
use App\Models\Login;
use App\Models\RequestBarangModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KirimBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kantorlayanan = RequestBarangModel::select('pop')
            ->whereIn('status', ['Menunggu Pengiriman', 'Sedang Dikirim'])
            ->distinct()
            ->get();
        return view('SuperAdmin.KirimBarang', ['kantorlayanan' => $kantorlayanan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kantorlayanan = KLModel::get();
        $requestBarang = RequestBarangModel::where('status', 'Setujui')->get();

        return view('SuperAdmin.InputKirimBarang', [
            'kantorlayanan' => $kantorlayanan,
            'requestBarang' => $requestBarang,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $popList = collect($request->items)->pluck('pop')->unique();

        $sedangDikirim = RequestBarangModel::whereIn('pop', $popList)
            ->whereIn('status', ['Sedang Dikirim', 'Menunggu Pengiriman'])
            ->exists();

        if ($sedangDikirim) {
            return redirect()->back()->with('error', 'Ada barang yang sedang dikirim ke lokasi terkait. Proses input dibatalkan.');
        }

        $sedangPending = RequestBarangModel::whereIn('pop', $popList)
            ->where('status', 'Pending')
            ->exists();

        if ($sedangPending) {
            return redirect()->back()->with('error', 'Proses input dibatalkan karena masih ada barang dengan status Pending untuk kantor layanan terkait. Harap selesaikan atau setujui permintaan sebelumnya sebelum melanjutkan.');
        }

        $sedangTolak = RequestBarangModel::whereIn('pop', $popList)
            ->where('status', 'Tolak')
            ->exists();

        if ($sedangTolak) {
            return redirect()->back()->with('error', 'Ada barang yang ditolak ke lokasi terkait. Proses input dibatalkan.');
        }

        foreach ($request->items as $item) {
            $namaPengaju = RequestBarangModel::where('pop', $item['pop'])
                ->where('status', 'Setujui')
                ->value('nama_pengaju');

            if (!$namaPengaju) {
                $namaPengaju = Login::whereHas('KLModel', function ($query) use ($item) {
                    $query->where('pop', $item['pop']);
                })
                    ->orderBy('last_login', 'desc')
                    ->value('username');
            }

            RequestBarangModel::updateOrCreate(
                [
                    'nama_barang' => $item['nama_barang'],
                    'seri'         => $item['seri'],
                    'pop'         => $item['pop']
                ], // Kriteria pencarian
                [
                    'jumlah'       => $item['jumlah'],
                    'satuan'       => $item['satuan'],
                    'rasio'        => $item['rasio'],
                    'catatan'      => $item['catatan'],
                    'pengirim'     => Auth::user()->username,
                    'nama_pengaju' => $namaPengaju,
                ] // Data yang akan diperbarui atau dibuat
            );
        }


        foreach ($popList as $lokasiNama) {
            if (RequestBarangModel::where('pop', $lokasiNama)->exists()) {
                RequestBarangModel::where('pop', $lokasiNama)->update(['status' => 'Menunggu Pengiriman']);
            }
        }
        return redirect()->back()->with('success', 'Data barang berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = RequestBarangModel::with('KLModel')->whereIn('status', ['Menunggu Pengiriman', 'Sedang Dikirim']);
        if ($request->pop) {
            $query->where('pop', $request->pop);
        }
        $results = $query->get();
        $results = $query->get()->map(function ($riwayat) {
            return [
                'id' => $riwayat->id,
                'nama_barang' => $riwayat->nama_barang,
                'seri' => $riwayat->seri,
                'jumlah' => $riwayat->jumlah,
                'satuan' => $riwayat->satuan,
                'rasio' => $riwayat->rasio,
                'catatan' => $riwayat->catatan,
                'lokasi' => $riwayat->KLModel->lokasi,
                'pop' => $riwayat->pop,
                'status' => $riwayat->status,
                'pengirim' => $riwayat->pengirim,
                'resi' => $riwayat->resi,
                'formatted_created_at' => Carbon::parse($riwayat->created_at)->format('d M Y, H:i'),
                'formatted_updated_at' => $riwayat->status == 'Sedang Dikirim' ? Carbon::parse($riwayat->updated_at)->format('d M Y, H:i') : null,
                'formatted_tanggal_terima' => $riwayat->tanggal_terima ? Carbon::parse($riwayat->tanggal_terima)->format('d M Y, H:i') : null,
                'formatted_tanggal_estimasi' => $riwayat->tanggal_estimasi ? Carbon::parse($riwayat->tanggal_estimasi)->format('d M Y, H:i') : null,
                'isLate' => $riwayat->tanggal_estimasi ? Carbon::parse($riwayat->tanggal_estimasi)->addDays(2)->isPast() : false,
            ];
        });

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
        $popArray = explode(',', $pop);
        RequestBarangModel::whereIn('pop', $popArray)
            ->update([
                'status' => 'Sedang Dikirim',
                'tanggal_estimasi' => $request->tanggal_estimasi . ' ' . now()->format('H:i:s'),
                'resi' => $request->resi,
                'namakurir' => $request->namakurir,
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
