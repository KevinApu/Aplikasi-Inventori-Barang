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
                'stok_awal' => 10,
                'in' => 0,
                'out' => 2,
                'pop' => 'G1',
                'stok_gudang_id' => 1,
                'created_at' => '2025-03-06 15:34:08',
                'updated_at' => '2025-04-27 19:08:55',
            ),
            1 => 
            array (
                'id' => 2,
                'stok_awal' => 100,
                'in' => 0,
                'out' => 10,
                'pop' => 'G1',
                'stok_gudang_id' => 2,
                'created_at' => '2025-04-23 12:36:48',
                'updated_at' => '2025-04-27 19:08:55',
            ),
            2 => 
            array (
                'id' => 3,
                'stok_awal' => 13,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 3,
                'created_at' => '2025-04-23 12:37:48',
                'updated_at' => '2025-04-25 00:32:39',
            ),
            3 => 
            array (
                'id' => 4,
                'stok_awal' => 20,
                'in' => 0,
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
                'in' => 0,
                'out' => 7,
                'pop' => 'G1',
                'stok_gudang_id' => 5,
                'created_at' => '2025-04-23 12:41:01',
                'updated_at' => '2025-04-27 19:08:55',
            ),
            5 => 
            array (
                'id' => 6,
                'stok_awal' => 11,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 6,
                'created_at' => '2025-04-23 12:41:58',
                'updated_at' => '2025-04-25 00:32:39',
            ),
            6 => 
            array (
                'id' => 7,
                'stok_awal' => 14,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 7,
                'created_at' => '2025-04-24 22:15:30',
                'updated_at' => '2025-04-25 00:32:39',
            ),
            7 => 
            array (
                'id' => 8,
                'stok_awal' => 150,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 8,
                'created_at' => '2025-04-24 22:16:42',
                'updated_at' => '2025-04-24 22:16:42',
            ),
            8 => 
            array (
                'id' => 9,
                'stok_awal' => 10,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 9,
                'created_at' => '2025-04-24 22:18:09',
                'updated_at' => '2025-04-24 22:18:09',
            ),
            9 => 
            array (
                'id' => 10,
                'stok_awal' => 50,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 10,
                'created_at' => '2025-04-24 22:18:53',
                'updated_at' => '2025-04-24 22:18:53',
            ),
            10 => 
            array (
                'id' => 11,
                'stok_awal' => 12,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 11,
                'created_at' => '2025-04-24 22:19:48',
                'updated_at' => '2025-04-24 22:19:48',
            ),
            11 => 
            array (
                'id' => 12,
                'stok_awal' => 14,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 12,
                'created_at' => '2025-04-24 22:20:30',
                'updated_at' => '2025-04-25 00:32:39',
            ),
            12 => 
            array (
                'id' => 13,
                'stok_awal' => 15,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 13,
                'created_at' => '2025-04-24 22:21:22',
                'updated_at' => '2025-04-24 22:21:22',
            ),
            13 => 
            array (
                'id' => 14,
                'stok_awal' => 7,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 14,
                'created_at' => '2025-04-24 22:22:08',
                'updated_at' => '2025-04-25 00:32:39',
            ),
            14 => 
            array (
                'id' => 15,
                'stok_awal' => 12,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 15,
                'created_at' => '2025-04-24 22:22:45',
                'updated_at' => '2025-04-25 00:32:39',
            ),
            15 => 
            array (
                'id' => 16,
                'stok_awal' => 30,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 16,
                'created_at' => '2025-04-24 22:23:38',
                'updated_at' => '2025-04-24 22:23:38',
            ),
            16 => 
            array (
                'id' => 17,
                'stok_awal' => 10,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 17,
                'created_at' => '2025-04-24 22:24:33',
                'updated_at' => '2025-04-25 00:32:39',
            ),
            17 => 
            array (
                'id' => 18,
                'stok_awal' => 120,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 18,
                'created_at' => '2025-04-24 22:25:06',
                'updated_at' => '2025-04-24 22:25:06',
            ),
            18 => 
            array (
                'id' => 19,
                'stok_awal' => 15,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 19,
                'created_at' => '2025-04-24 22:25:44',
                'updated_at' => '2025-04-24 22:25:44',
            ),
            19 => 
            array (
                'id' => 20,
                'stok_awal' => 8,
                'in' => 0,
                'out' => 0,
                'pop' => 'G1',
                'stok_gudang_id' => 20,
                'created_at' => '2025-04-24 22:27:00',
                'updated_at' => '2025-04-25 00:32:39',
            ),
        ));
        
        
    }
}