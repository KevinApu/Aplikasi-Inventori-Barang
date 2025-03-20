<?php

use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\SettingController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangRusakController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Print\LaporanController;
use App\Http\Controllers\Print\PrintControlller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\RequestBarangController;
use App\Http\Controllers\StokGudangController;
use App\Http\Controllers\SuperAdmin\KirimBarangController;
use App\Http\Controllers\SuperAdmin\KLController;
use App\Http\Controllers\SuperAdmin\PermintaanBarangController;
use App\Models\BarangKeluarModel;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route::get('/tabel_barang_masuk/admin', [KLController::class, 'index'])->name('tabel_barang_masuk.superadmin');
Route::get('/coba', function () {
    return view('welcome');
});



// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
// });


Route::middleware(['auth', 'clear.temp_items'])->group(function () {
    Route::middleware(['clear.temp_items'])->group(function () {
        Route::middleware(['not_super_admin'])->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        });

        Route::middleware(['admin'])->group(function () {
            Route::get('/input_barang_masuk', [BarangMasukController::class, 'create'])->name('input_barang_masuk.view');
            Route::post('/input_barang_masuk', [BarangMasukController::class, 'store'])->name('input_barang_masuk');
            Route::get('/tabel_barang_masuk', [BarangMasukController::class, 'index'])->name('tabel_barang_masuk');
            Route::put('/update_barang_masuk/{id}', [BarangMasukController::class, 'update'])->name('update_barang_masuk');
            Route::post('/penambahan_stok/{id}', [BarangMasukController::class, 'penambahan_stok'])->name('penambahan_stok');
            Route::post('/input_barang_rusak/{id}', [BarangRusakController::class, 'store'])->name('barang.rusak');
            Route::get('/request_barang', [RequestBarangController::class, 'create'])->name('request_barang');
            Route::post('/request_barang/post', [RequestBarangController::class, 'store'])->name('request_barang.post');
            Route::post('/terima_barang/{pop}', [RequestBarangController::class, 'update'])->name('terima_barang');
        });



        Route::middleware(['super_admin'])->group(function () {
            Route::get('/tabel_barang_masuk/admin', [KLController::class, 'index'])->name('tabel_barang_masuk.superadmin');
            Route::post('/requestbarang/setujui/multiple', [PermintaanBarangController::class, 'setujuiMultiple'])->name('requestbarang.setujuiMultiple');
            Route::post('/requestbarang/tolak/multiple', [PermintaanBarangController::class, 'tolakMultiple'])->name('requestbarang.tolakMultiple');
            Route::get('/search/pop', [KLController::class, 'show']);
            Route::get('/search/pengiriman', [KirimBarangController::class, 'show']);

            Route::get('/pengiriman_barang/input/admin', [KirimBarangController::class, 'create'])->name('pengiriman_barang.input.superadmin');
            Route::post('/pengiriman_barang/input/admin/post', [KirimBarangController::class, 'store'])->name('pengiriman_barang.input.post.superadmin');
            Route::get('/pengiriman_barang/admin', [KirimBarangController::class, 'index'])->name('pengiriman_barang.superadmin');
            Route::post('/update-shipping/{pop}', [KirimBarangController::class, 'update'])->name('update-shipping');


            Route::get('/permintaan_barang/admin', [PermintaanBarangController::class, 'index'])->name('permintaan_barang.superadmin');

            Route::post('/setting/pop', [KLController::class, 'store'])->name('setting.pop');
            Route::put('/setting/pop/update/{pop}', [KLController::class, 'update'])->name('setting.pop.update');
            Route::delete('/setting/pop/delete/{pop}', [KLController::class, 'destroy'])->name('setting.pop.destroy');
            
            Route::put('/password.update', [SettingController::class, 'update_password'])->name('password.update');

            Route::post('/tambah_user/{pop}', [SettingController::class, 'add_user'])->name('add.user');
            Route::delete('/hapus_user/{id}', [SettingController::class, 'destroy_user'])->name('destroy.user');
        });
        
        
        Route::post('/profile_picture.store', [SettingController::class, 'update_profile_picture'])->name('profile_picture.store');
        Route::put('/username.update', [SettingController::class, 'update_username'])->name('username.update');


        Route::post('/kategori/baru', [BarangMasukController::class, 'kategori'])->name('kategori.baru');
        Route::post('/namabarang/baru', [BarangMasukController::class, 'namabarang'])->name('namabarang.baru');




        Route::get('/tabel_barang_keluar', [BarangKeluarController::class, 'index'])->name('tabel_barang_keluar');
        Route::get('/input_barang_keluar', [BarangKeluarController::class, 'create'])->name('input_barang_keluar');
        Route::post('/barang_keluar', [BarangKeluarController::class, 'store'])->name('barangkeluar.store');
        Route::get('/hapus_order/{id}', [BarangKeluarController::class, 'destroy_order']);
        Route::delete('/tabel_barang_keluar/{id}', [BarangKeluarController::class, 'destroy']);


        Route::get('/search/barangmasuk', [BarangMasukController::class, 'show']);
        Route::get('/search/barangkeluar', [BarangKeluarController::class, 'show']);
        Route::get('/search/barangrusak', [BarangRusakController::class, 'show']);
        Route::get('/search/stokgudang', [StokGudangController::class, 'show']);
        Route::get('/search/rekap', [RekapController::class, 'show']);
        Route::get('/search/kl', [KLController::class, 'show']);

        Route::post('/order/{id}', [BarangKeluarController::class, 'order'])->name('order');




        Route::get('/tabel_barang_rusak', [BarangRusakController::class, 'index'])->name('tabel_barang_rusak');

        Route::post('/settings/notifications', [NotificationController::class, 'updateSettings'])->name('notification.update');
        Route::get('/settings/notifications/reset', [NotificationController::class, 'resetSettings'])->name('notification.reset');

        Route::get('/tabel_stok_gudang', [StokGudangController::class, 'index'])->name('tabel_stok_gudang');

        Route::get('/update_rekap_stok', [RekapController::class, 'updateRekapBulanan'])->name('update_rekap_stok');

        Route::delete('/hapus_barang_rusak/{id}', [BarangRusakController::class, 'destroy']);

        Route::get('/request-access', [LoginUserController::class, 'requestAccess'])->name('request.access');



        Route::middleware(['khusus_admin'])->group(function () {
            Route::post('/admin/approve-access/{id}', [LoginUserController::class, 'approveAccess'])->name('admin.approve.access');
            Route::post('/admin/delete-access/{id}', [LoginUserController::class, 'deleteAccess'])->name('admin.delete.access');
            Route::post('/view_barang_true/{id}', [SettingController::class, 'view_barang_true']);
            Route::post('/view_barang_false/{id}', [SettingController::class, 'view_barang_false']);
        });

        Route::post('/submitprint', [PrintControlller::class, 'create'])->name('submitPrint');
        Route::get('/search/barcode', [BarangMasukController::class, 'barcode']);
        Route::get('/settings', [SettingController::class, 'index'])->name('setting');
    });

    Route::get('/print_barcode', [PrintControlller::class, 'printbarcode'])->name('print.barcode');
    Route::get('/barcode', [PrintControlller::class, 'index'])->name('barcode');

    Route::get('/view_laporan', [LaporanController::class, 'viewlaporan'])->name('view.laporan');
    Route::get('/print_laporan', [LaporanController::class, 'printlaporan'])->name('print.laporan');
    Route::get('/view_laporan_suratjalan', [LaporanController::class, 'viewsuratjalan'])->name('view.print.suratjalan');
    Route::get('/print_laporan_suratjalan', [LaporanController::class, 'printsuratjalan'])->name('print.suratjalan');
    Route::get('/view.laporan.rekap', [LaporanController::class, 'viewlaporanrekap'])->name('view.laporan.rekap');
    Route::get('/print.laporan.rekap', [LaporanController::class, 'printlaporanrekap'])->name('print.laporan.rekap');
});


require __DIR__ . '/auth.php';
