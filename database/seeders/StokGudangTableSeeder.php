<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokGudangTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('stok_gudang')->delete();
    
        DB::table('stok_gudang')->insert(array (
            0 => 
            array (
                'id' => 1,
                'kode_barang' => '222',
                'kategori' => 'Elektronik',
                'nama_barang' => 'Kipas Angin',
                'seri' => '-',
                'jumlah' => 5,
                'satuan' => 'pcs',
                'rasio' => NULL,
                'hasil' => NULL,
                'detail_jumlah' => NULL,
                'lokasi' => 'Rak Bawah',
                'foto' => 'img/1745387150-iS0Mz2Ve6mObPvTyfmqsgiyeX7HwJfrPqjt5y6Jx.jpg',
                'input_by' => 'kevin',
                'keterangan' => NULL,
                'pop' => 'G1',
                'created_at' => '2025-03-06 15:34:08',
                'updated_at' => '2025-04-23 13:16:04',
            ),
            1 => 
            array (
                'id' => 2,
                'kode_barang' => '6756',
                'kategori' => 'Alat Tulis',
                'nama_barang' => 'Pulpen',
                'seri' => 'joyko',
                'jumlah' => 100,
                'satuan' => 'pcs',
                'rasio' => NULL,
                'hasil' => NULL,
                'detail_jumlah' => NULL,
                'lokasi' => 'Laci Meja',
                'foto' => 'img/1745386608-PyOFz5CvzPQW9e3nzb5u14Qybulm99Wob2AUctEC.jpg',
                'input_by' => 'kevin',
                'keterangan' => NULL,
                'pop' => 'G1',
                'created_at' => '2025-03-06 12:36:48',
                'updated_at' => '2025-04-23 13:19:24',
            ),
            2 => 
            array (
                'id' => 3,
                'kode_barang' => '8899',
                'kategori' => 'Perkakas',
                'nama_barang' => 'Obeng Set',
                'seri' => 'OB-SET-X',
                'jumlah' => 8,
                'satuan' => 'unit',
                'rasio' => NULL,
                'hasil' => NULL,
                'detail_jumlah' => NULL,
                'lokasi' => 'Lemari Kecil',
                'foto' => 'img/1745386668-s8RYc48Dq3z880suZboD7LyRDTHOJybiQbC2CfGJ.jpg',
                'input_by' => 'kevin',
                'keterangan' => NULL,
                'pop' => 'G1',
                'created_at' => '2025-04-23 12:37:48',
                'updated_at' => '2025-04-23 12:37:48',
            ),
            3 => 
            array (
                'id' => 4,
                'kode_barang' => '4455',
                'kategori' => 'Kebersihan',
                'nama_barang' => 'Tisu Gulung',
                'seri' => '-',
                'jumlah' => 20,
                'satuan' => 'pcs',
                'rasio' => NULL,
                'hasil' => NULL,
                'detail_jumlah' => NULL,
                'lokasi' => 'Gudang Belakang',
                'foto' => 'img/1745386728-iFskBudC1sBTMs46Lkv0kEBhZltQz9mfS2AfQJ0e.jpg',
                'input_by' => 'kevin',
                'keterangan' => NULL,
                'pop' => 'G1',
                'created_at' => '2024-04-11 12:38:48',
                'updated_at' => '2024-04-11 12:38:48',
            ),
            4 => 
            array (
                'id' => 5,
                'kode_barang' => '6762',
                'kategori' => 'Kebersihan',
                'nama_barang' => 'Masker',
                'seri' => 'Sensi',
                'jumlah' => 25,
                'satuan' => 'pack',
                'rasio' => 10,
                'hasil' => 250,
                'detail_jumlah' => 10,
                'lokasi' => 'Lemari Atas',
                'foto' => 'img/1745386861-dTydiWwmiOrYLVkpLNmYZjQZI7O00OjD5pLyYSW7.jpg',
                'input_by' => 'kevin',
                'keterangan' => NULL,
                'pop' => 'G1',
                'created_at' => '2020-05-08 12:41:01',
                'updated_at' => '2025-04-23 13:19:24',
            ),
            5 => 
            array (
                'id' => 6,
                'kode_barang' => '3210',
                'kategori' => 'Dapur',
                'nama_barang' => 'Dispenser Air',
                'seri' => 'DPN-ZX',
                'jumlah' => 5,
                'satuan' => 'unit',
                'rasio' => NULL,
                'hasil' => NULL,
                'detail_jumlah' => NULL,
                'lokasi' => 'Ruang Istirahat',
                'foto' => 'img/1745386918-HodJmkSVw698zutOaj8TnsBsGmU0HueSPXrxURZO.jpg',
                'input_by' => 'kevin',
                'keterangan' => NULL,
                'pop' => 'G1',
                'created_at' => '2025-02-10 12:41:58',
                'updated_at' => '2025-02-10 12:41:58',
            ),
        ));
        
        
    }
}