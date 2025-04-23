<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RekapTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('rekap')->delete();
    
        DB::table('rekap')->insert(array (
            0 => 
            array (
                'id' => 1,
                'stok_awal' => 5,
                'in' => 5,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 1,
                'created_at' => '2025-03-06 15:34:08',
                'updated_at' => '2025-04-23 13:16:04',
            ),
            1 => 
            array (
                'id' => 2,
                'stok_awal' => 100,
                'in' => 100,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 2,
                'created_at' => '2025-04-23 12:36:48',
                'updated_at' => '2025-04-23 13:19:24',
            ),
            2 => 
            array (
                'id' => 3,
                'stok_awal' => 8,
                'in' => 8,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 3,
                'created_at' => '2025-04-23 12:37:48',
                'updated_at' => '2025-04-23 12:37:48',
            ),
            3 => 
            array (
                'id' => 4,
                'stok_awal' => 20,
                'in' => 20,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 4,
                'created_at' => '2025-04-23 12:38:48',
                'updated_at' => '2025-04-23 12:38:48',
            ),
            4 => 
            array (
                'id' => 5,
                'stok_awal' => 250,
                'in' => 250,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 5,
                'created_at' => '2025-04-23 12:41:01',
                'updated_at' => '2025-04-23 13:19:24',
            ),
            5 => 
            array (
                'id' => 6,
                'stok_awal' => 6,
                'in' => 6,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 6,
                'created_at' => '2025-04-23 12:41:58',
                'updated_at' => '2025-04-23 12:41:58',
            ),
        ));
        
        
    }
}