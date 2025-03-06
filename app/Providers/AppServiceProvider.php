<?php

namespace App\Providers;

use App\Models\KLModel;
use App\Models\NotificationSetting;
use App\Models\PengirimanModel;
use App\Models\RequestBarangModel;
use App\Models\StokGudangModel;
use App\Models\User;
use Carbon\Carbon;
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
                $currentPop = Auth::user()->pop;
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

            // Request access berdasarkan pop
            $request_access = User::where('pop', $currentPop)
                ->where('request_access', true)
                ->get()
                ->groupBy('pop');

            $request_access_count = $request_access->sum(fn($group) => $group->count());

            $view->with([
                'barangKurang' => $barangKurang,
                'barangKurangCount' => $barangKurang->sum(fn($group) => $group->count()),
                'request_access' => $request_access,
                'request_access_count' => $request_access_count,
            ]);
        });









        View::composer('layouts.sidebar', function ($view) {
            $menunggu_pengiriman = PengirimanModel::where('status', 'Menunggu Pengiriman')
                ->get()
                ->groupBy('tujuan')
                ->map(function ($items) {
                    $tujuan = $items->first()->tujuan;
                    $Pop = KLModel::where('lokasi', $tujuan)->pluck('pop')->first();

                    return (object) [
                        'tujuan' => $Pop,
                        'tujuan_lokasi' => $tujuan,
                        'status' => 'Menunggu Pengiriman',
                        'waktu' => $items->first()->waktu,
                    ];
                });




            $lokasiNama = RequestBarangModel::where('status', 'Setujui')->get();
            $lokasiUnik = $lokasiNama->unique('pop');
            $gabungan = $lokasiUnik->map(function ($item) {
                $pop = KLModel::where('lokasi', $item->pop)->value('pop');

                return (object) [
                    'tujuan' => $pop,
                    'tujuan_lokasi' => $item->pop,
                    'status' => 'Menunggu penginputan barang',
                    'waktu' => now()->toDateTimeString(),
                ];
            });
            $data_tergabung = $menunggu_pengiriman->concat($gabungan);
            $data_tergabung_count = $data_tergabung->count();


            $request_barang_all = RequestBarangModel::where('status', 'Pending')->get();
            $request_barang = $request_barang_all->unique('pop');
            $request_barang_count = $request_barang->count();


            $foto_profile = Auth::user()->foto;

            $view->with('data_tergabung', $data_tergabung);
            $view->with('data_tergabung_count', $data_tergabung_count);

            $view->with('request_barang_count', $request_barang_count);
            $view->with('foto_profile', $foto_profile);
        });
    }
}
