<?php

namespace App\Providers;

use App\Models\KLModel;
use App\Models\Login;
use App\Models\NotificationSetting;
use App\Models\RequestBarangModel;
use App\Models\StokGudangModel;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $klUser = Auth::user();

                if ($klUser->role === 'superadmin') {
                    $currentPop = 'Superadmin'; // Atau bisa null tergantung kebutuhan
                } else {
                    $currentPop = $klUser->KLModel->pop;
                }
            } else {
                $currentPop = null;
            }

            // Barang kurang berdasarkan pop
            $settings = NotificationSetting::first() ?? new NotificationSetting();

            $barangKurang = StokGudangModel::where('pop', $currentPop)
                ->where(function ($query) use ($settings) {
                    $query->where('jumlah', '<', $settings->roll)->where('satuan', 'roll')
                        ->orWhere('jumlah', '<', $settings->pack)->where('satuan', 'pack')
                        ->orWhere('jumlah', '<', $settings->unit)->where('satuan', 'unit')
                        ->orWhere('jumlah', '<', $settings->pcs)->where('satuan', 'pcs');
                })
                ->get()
                ->groupBy('pop') // Kelompokkan berdasarkan pop
                ->map(function ($group) {
                    return $group->map(function ($barang) {
                        $barang->waktu = Carbon::createFromFormat('Y-m-d H:i:s', $barang->updated_at)->diffForHumans();
                        return $barang;
                    });
                });

            $request_access = Login::whereHas('KLModel', function ($query) use ($currentPop) {
                $query->where('pop', $currentPop);
            })
                ->where('request_access', true)
                ->get()
                ->groupBy(fn($user) => $user->KLModel->pop);


            $request_access_count = $request_access->sum(fn($group) => $group->count());

            $view->with([
                'barangKurang' => $barangKurang,
                'barangKurangCount' => $barangKurang->sum(fn($group) => $group->count()),
                'request_access' => $request_access,
                'request_access_count' => $request_access_count,
            ]);
        });









        View::composer('layouts.sidebar', function ($view) {
            $menunggu_pengiriman = RequestBarangModel::where('status', 'Menunggu Pengiriman')
                ->get()
                ->groupBy('pop')
                ->map(function ($items) {
                    $pop = $items->first()->pop;
                    $kl = KLModel::where('pop', $pop)->first();

                    return (object) [
                        'tujuan' => $pop,
                        'tujuan_lokasi' => optional($kl)->lokasi,
                        'status' => 'Menunggu Pengiriman',
                        'waktu' => Carbon::parse($items->first()->updated_at)->diffForHumans(),
                    ];
                });




            $lokasiNama = RequestBarangModel::where('status', 'Setujui')->get();
            $lokasiUnik = $lokasiNama->unique('pop');

            $gabungan = $lokasiUnik->map(function ($item) {
                // Ambil data KLModel berdasarkan pop
                $kl = KLModel::where('pop', $item->pop)->first();

                return (object) [
                    'tujuan' => $item->pop,
                    'tujuan_lokasi' => optional($kl)->lokasi,
                    'status' => 'Menunggu penginputan barang',
                    'waktu' => Carbon::parse($item->first()->updated_at)->diffForHumans(),
                ];
            });

            // Menggabungkan data menunggu pengiriman dengan data gabungan
            $data_tergabung = $menunggu_pengiriman->concat($gabungan);
            $data_tergabung_count = $data_tergabung->count();

            // Menghitung jumlah request barang yang masih pending
            $request_barang_all = RequestBarangModel::where('status', 'Pending')->get();
            $request_barang = $request_barang_all->unique('pop');
            $request_barang_count = $request_barang->count();

            $view->with('data_tergabung', $data_tergabung);
            $view->with('data_tergabung_count', $data_tergabung_count);
            $view->with('request_barang_count', $request_barang_count);

            $foto_profile = Auth::user()->foto;
            $view->with('foto_profile', $foto_profile);
        });
    }
}
