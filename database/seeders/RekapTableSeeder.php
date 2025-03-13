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
                'stok_awal' => 22,
                'in' => 4,
                'out' => 2,
                'pop' => 'G1',
                'stok_gudang_id' => 1,
                'created_at' => '2025-03-06 15:34:08',
                'updated_at' => '2025-03-06 16:32:32',
            ),
            1 => 
            array (
                'id' => 2,
                'stok_awal' => 200,
                'in' => 0,
                'out' => 2,
                'pop' => 'G1',
                'stok_gudang_id' => 2,
                'created_at' => '2025-03-06 16:00:15',
                'updated_at' => '2025-03-06 16:31:46',
            ),
        ));
        
        
    }
}