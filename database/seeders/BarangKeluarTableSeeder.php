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
                'id' => 6,
                'jumlah' => 1,
                'lokasi' => 'asdasd',
                'nama_customer' => '343243_asdasd',
                'output_by' => 'kevin pkl',
                'keterangan' => NULL,
                'pop' => 'G1',
                'qr_code' => 'ec00b4c0656444cc9672396750d51141',
                'stok_gudang_id' => 2,
                'created_at' => '2025-03-06 16:31:46',
                'updated_at' => '2025-03-06 16:31:46',
            ),
        ));
        
        
    }
}