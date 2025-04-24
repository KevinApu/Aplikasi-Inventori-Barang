<?php

namespace App\Http\Controllers;

use App\Models\RekapModel;
use App\Models\RequestBarangModel;
use App\Models\StokGudangModel;
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

        $resultstatus = RequestBarangModel::where('pop', $pop)
            ->whereIn('status', ['Menunggu Pengiriman', 'Sedang Dikirim'])
            ->get();

        $result = RequestBarangModel::where('pop', $pop)
            ->get();

        if ($resultstatus->isNotEmpty()) {
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
        $requests = RequestBarangModel::where('pop', $pop)->get();
        $barangBaru = [];

        foreach ($requests as $req) {
            $stok = StokGudangModel::where('nama_barang', $req->nama_barang)
                ->where('seri', $req->seri)
                ->where('pop', $req->pop)
                ->first();

            if ($stok) {
                if (in_array($stok->satuan, ['roll', 'pack'])) {
                    $totalHasil = $stok->hasil + ($req->jumlah * $stok->rasio);
                    $stok->jumlah = ceil($totalHasil / $stok->rasio);
                    $stok->detail_jumlah = $totalHasil % $stok->rasio;
                    $stok->hasil = $totalHasil;
                } else {
                    $stok->jumlah += $req->jumlah;
                }
                $stok->save();

                // Update Rekap
                $rekap = RekapModel::firstOrNew(['stok_gudang_id' => $stok->id]);
                $rekap->in = ($rekap->in ?? 0) + ($req->jumlah * ($stok->rasio ?? 1));
                $rekap->save();
            } else {
                $barangBaru = array_merge($barangBaru, [$req->nama_barang]);
            }
        }

        // Hapus permintaan yang sudah diproses
        RequestBarangModel::where('pop', $pop)->delete();

        // Berikan notifikasi jika ada barang baru
        if (!empty($barangBaru)) {
            $daftarBarang = implode(', ', $barangBaru);
            return redirect()->back()->with('info', "Sebagian barang berhasil diproses. Barang baru terdeteksi: $daftarBarang. Silakan input data lengkap barang baru secara manual.");
        }

        // Setelah memindahkan data ke StokGudangModel, hapus data dari RequestBarangModel
        RequestBarangModel::where('pop', $pop)->delete();


        return redirect()->back()->with('success', 'Semua permintaan barang berhasil diproses dan ditambahkan ke stok.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
