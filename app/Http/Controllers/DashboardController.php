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
        return view('dashboard', compact('barang_masuk', 'barang_keluar', 'barang_rusak'));
    }
}