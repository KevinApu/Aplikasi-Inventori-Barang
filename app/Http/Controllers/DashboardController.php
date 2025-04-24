<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluarModel;
use App\Models\BarangMasukModel;
use App\Models\BarangRusakModel;
use App\Models\StokGudangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $pop = Auth::user()->KLModel->pop;
        $barang_masuk = StokGudangModel::where('pop', $pop)->sum('jumlah');
        $barang_keluar = BarangKeluarModel::where('pop', $pop)
            ->where('status_order', 1)
            ->sum('jumlah');
        $barang_rusak = BarangRusakModel::where('pop', $pop)->sum('jumlah');

        $daftarBarangKeluar = BarangKeluarModel::with('stokGudang')
            ->where('status_order', 1)
            ->where('pop', $pop)
            ->get();

        // Kelompokkan berdasarkan stok_gudang_id dan ambil hanya satu row per stok_gudang_id
        $daftarBarangKeluar = $daftarBarangKeluar->groupBy('stok_gudang_id')->map(function ($item) {
            return $item->first(); // Ambil hanya satu row untuk setiap grup stok_gudang_id
        });


        return view('dashboard', compact('barang_masuk', 'barang_keluar', 'barang_rusak', 'daftarBarangKeluar'));
    }

    public function show($id)
    {
        $pop = Auth::user()->KLModel->pop;
        $tahun = date('Y');

        $query = BarangKeluarModel::selectRaw('MONTH(created_at) as bulan, SUM(jumlah) as total')
            ->whereYear('created_at', $tahun)
            ->where('pop', $pop);

        // Jika bukan "all", tambahkan filter stok_gudang_id
        if ($id !== 'all') {
            $query->where('stok_gudang_id', $id);
        }

        $barangKeluarPerBulan = $query->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Format data untuk chart
        $labels = [];
        $data = [];

        foreach ($barangKeluarPerBulan as $row) {
            $labels[] = date("F", mktime(0, 0, 0, $row->bulan, 1)); // Nama bulan
            $data[] = $row->total;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
