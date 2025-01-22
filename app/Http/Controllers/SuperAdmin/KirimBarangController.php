<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KirimBarangRequest;
use App\Models\KLModel;
use App\Models\PengirimanModel;
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
        $kantorlayanan = PengirimanModel::select('tujuan')->distinct()->get();
        return view('SuperAdmin.KirimBarang', ['kantorlayanan' => $kantorlayanan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kantorlayanan = KLModel::where('lokasi', '!=', 'pusat')->get();
        return view('SuperAdmin.InputKirimBarang', ['kantorlayanan' => $kantorlayanan]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $lokasiList = collect($request->items)->pluck('lokasi')->unique();

        $sedangDikirim = PengirimanModel::whereIn('tujuan', $lokasiList)
            ->whereIn('status', ['Sedang Dikirim', 'Menunggu Pengiriman'])
            ->exists();

        if ($sedangDikirim) {
            return redirect()->back()->with('error', 'Ada barang yang sedang dikirim ke lokasi terkait. Proses input dibatalkan.');
        }

        $sedangPending = RequestBarangModel::whereIn('pop', $lokasiList)
            ->where('status', 'Pending')
            ->exists();

        if ($sedangPending) {
            return redirect()->back()->with('error', 'Proses input dibatalkan karena masih ada barang dengan status Pending untuk kantor layanan terkait. Harap selesaikan atau setujui permintaan sebelumnya sebelum melanjutkan.');
        }


        $sedangTolak = RequestBarangModel::whereIn('pop', $lokasiList)
            ->where('status', 'Tolak')
            ->exists();

        if ($sedangTolak) {
            return redirect()->back()->with('error', 'Ada barang yang ditolak ke lokasi terkait. Proses input dibatalkan.');
        }

        foreach ($request->items as $item) {
            PengirimanModel::create([
                'nama_barang' => $item['nama_barang'],
                'seri'        => $item['seri'],
                'jumlah'      => $item['jumlah'],
                'satuan'      => $item['satuan'],
                'rasio'       => $item['rasio'],
                'tujuan'      => $item['lokasi'],
                'catatan'     => $item['catatan'],
                'pengirim'    => Auth::user()->username,
                'nama_pengaju' => RequestBarangModel::where('pop', $item['lokasi'])
                    ->where('status', 'Setujui')
                    ->value('nama_pengaju'),
            ]);
        }

        foreach ($lokasiList as $lokasiNama) {
            // Jika lokasi ditemukan di RequestBarangModel, perbarui status
            if (RequestBarangModel::where('pop', $lokasiNama)->exists()) {
                RequestBarangModel::where('pop', $lokasiNama)->update(['status' => 'Dikirim']);
            }
        }
        return redirect()->back()->with('success', 'Data barang berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = DB::table('riwayat_pengiriman');

        // Menambahkan filter jika ada parameter 'pop'
        if ($request->pop) {
            $query->where('tujuan', $request->pop);
        }

        // Mengambil data dari query
        $results = $query->get();

        // Memformat tanggal setelah data diambil
        foreach ($results as $riwayat) {
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

        // Mengembalikan hasil sebagai JSON
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
    public function update(Request $request, $tujuan)
    {
        $request->estimasi . ' ' . now()->format('H:i:s');  // Tanggal estimasi
        $resi = $request->input('resi');  // Resi

        // Pisahkan tujuan menjadi array
        $tujuanArray = explode(',', $tujuan);  // Mengubah string tujuan menjadi array berdasarkan koma

        // Update data yang sesuai dengan tujuan
        PengirimanModel::whereIn('tujuan', $tujuanArray)
            ->update([
                'status' => 'Sedang Dikirim',
                'tanggal_estimasi' => $request->tanggal_estimasi . ' ' . now()->format('H:i:s'),
                'resi' => $resi,
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
