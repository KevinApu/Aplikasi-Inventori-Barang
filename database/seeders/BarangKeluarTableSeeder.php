<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangKeluarTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('barang_keluar')->delete();
        
        DB::table('barang_keluar')->insert(array (
            0 => 
            array (
                'id' => 1,
                'jumlah' => 2,
                'lokasi' => 'Beleharjo',
                'nama_customer' => '345509_Rasya',
                'output_by' => 'kevin',
                'status_order' => 1,
                'keterangan' => NULL,
                'pop' => 'G1',
                'stok_gudang_id' => 1,
                'created_at' => '2025-04-25 07:58:58',
                'updated_at' => '2025-04-27 19:08:55',
            ),
            1 => 
            array (
                'id' => 2,
                'jumlah' => 10,
                'lokasi' => 'Beleharjo',
                'nama_customer' => '345509_Rasya',
                'output_by' => 'kevin',
                'status_order' => 1,
                'keterangan' => NULL,
                'pop' => 'G1',
                'stok_gudang_id' => 2,
                'created_at' => '2025-04-25 07:59:18',
                'updated_at' => '2025-04-27 19:08:55',
            ),
            2 => 
            array (
                'id' => 3,
                'jumlah' => 7,
                'lokasi' => 'Beleharjo',
                'nama_customer' => '345509_Rasya',
                'output_by' => 'kevin',
                'status_order' => 1,
                'keterangan' => NULL,
                'pop' => 'G1',
                'stok_gudang_id' => 5,
                'created_at' => '2025-04-25 07:59:34',
                'updated_at' => '2025-04-27 19:08:55',
            ),
            3 => 
            array (
                'id' => 7,
                'jumlah' => 7,
                'lokasi' => 'Bangunsari',
                'nama_customer' => '874806_Rizky',
                'output_by' => 'kevin',
                'status_order' => 1,
                'keterangan' => NULL,
                'pop' => 'G1',
                'stok_gudang_id' => 1,
                'created_at' => '2025-03-04 19:10:25',
                'updated_at' => '2025-03-04 19:10:25',
            ),
            4 => 
            array (
                'id' => 8,
                'jumlah' => 3,
                'lokasi' => 'Bangunsari',
                'nama_customer' => '874806_Rizky',
                'output_by' => 'kevin',
                'status_order' => 0,
                'keterangan' => NULL,
                'pop' => 'G1',
                'stok_gudang_id' => 19,
                'created_at' => '2025-03-04 19:10:25',
                'updated_at' => '2025-03-04 19:10:25',
            ),
            5 => 
            array (
                'id' => 11,
                'jumlah' => 2,
                'lokasi' => 'Kebonagung, Pacitan',
                'nama_customer' => '469636_Pamungkas',
                'output_by' => 'kevin',
                'status_order' => 1,
                'keterangan' => NULL,
                'pop' => 'G1',
                'stok_gudang_id' => 17,
                'created_at' => '2025-02-07 19:15:04',
                'updated_at' => '2025-02-07 19:15:04',
            ),
            6 => 
            array (
                'id' => 12,
                'jumlah' => 8,
                'lokasi' => 'Bengkal Tanjungsari',
                'nama_customer' => '2142454_Ilham',
                'output_by' => 'kevin',
                'status_order' => 0,
                'keterangan' => NULL,
                'pop' => 'G1',
                'stok_gudang_id' => 20,
                'created_at' => '2025-01-23 19:15:04',
                'updated_at' => '2025-01-23 19:15:04',
            ),
        ));
        
        
    }
}