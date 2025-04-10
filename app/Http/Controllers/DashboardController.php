<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluarModel;
use App\Models\BarangMasukModel;
use App\Models\BarangRusakModel;
use App\Models\StokGudangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pop = Auth::user()->KLModel->pop;
        $barang_masuk = StokGudangModel::where('pop', $pop)->sum('jumlah');
        $barang_keluar = BarangKeluarModel::where('pop', $pop)->sum('jumlah');
        $barang_rusak = BarangRusakModel::where('pop', $pop)->sum('jumlah');

        $tahun = date('Y');
        $barangKeluarPerBulan = BarangKeluarModel::selectRaw('MONTH(created_at) as bulan, SUM(jumlah) as total')
            ->whereYear('created_at', $tahun)
            ->where('pop', $pop)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();


        // Format data untuk chart
        $labels = [];
        $data = [];
        foreach ($barangKeluarPerBulan as $row) {
            $labels[] = date("F", mktime(0, 0, 0, $row->bulan, 1)); // Konversi bulan ke nama (Januari, Februari, dll)
            $data[] = $row->total;
        }

        return view('dashboard', compact('barang_masuk', 'barang_keluar', 'barang_rusak', 'labels', 'data'));
    }
}
