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
            'stok_awal' => 50,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-12-02 14:06:17',
            'updated_at' => '2024-12-02 14:06:17',
            ),
            1 => 
            array (
            'id' => 2,
            'stok_awal' => 750,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-12-02 14:14:24',
            'updated_at' => '2024-12-02 14:14:24',
            ),
            2 => 
            array (
            'id' => 3,
            'stok_awal' => 40,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-12-02 14:20:52',
            'updated_at' => '2024-12-02 14:20:52',
            ),
            3 => 
            array (
            'id' => 4,
            'stok_awal' => 40,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-12-02 14:21:56',
            'updated_at' => '2024-12-02 14:21:56',
            ),
            4 => 
            array (
            'id' => 5,
            'stok_awal' => 5,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-12-02 14:25:43',
            'updated_at' => '2024-12-02 14:25:43',
            ),
            5 => 
            array (
            'id' => 6,
            'stok_awal' => 3500,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-12-02 14:34:52',
            'updated_at' => '2024-12-02 14:34:52',
            ),
            6 => 
            array (
            'id' => 7,
            'stok_awal' => 2500,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-12-02 14:38:01',
            'updated_at' => '2024-12-02 14:38:01',
            ),
            7 => 
            array (
            'id' => 8,
            'stok_awal' => 24,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-12-02 14:39:09',
            'updated_at' => '2024-12-02 14:39:09',
            ),
            8 => 
            array (
            'id' => 9,
            'stok_awal' => 6000,
            'in' => NULL,
            'out' => 100,
            'pop' => 'G1',
            'created_at' => '2024-11-19 09:21:10',
            'updated_at' => '2024-12-06 10:57:14',
            ),
            9 => 
            array (
            'id' => 10,
            'stok_awal' => 6,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-11-19 09:24:41',
            'updated_at' => '2024-11-19 09:24:41',
            ),
            10 => 
            array (
            'id' => 11,
            'stok_awal' => 10,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-11-19 09:26:50',
            'updated_at' => '2024-11-19 09:26:50',
            ),
            11 => 
            array (
            'id' => 12,
            'stok_awal' => 2,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-11-19 09:29:54',
            'updated_at' => '2024-11-19 09:29:54',
            ),
            12 => 
            array (
            'id' => 13,
            'stok_awal' => 2,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-11-19 09:30:53',
            'updated_at' => '2024-11-19 09:30:53',
            ),
            13 => 
            array (
            'id' => 14,
            'stok_awal' => 2,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-11-19 09:34:51',
            'updated_at' => '2024-11-19 09:34:51',
            ),
            14 => 
            array (
            'id' => 15,
            'stok_awal' => 40,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-11-19 09:36:40',
            'updated_at' => '2024-11-19 09:36:40',
            ),
            15 => 
            array (
            'id' => 16,
            'stok_awal' => 5,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-11-19 09:38:25',
            'updated_at' => '2024-11-19 09:38:25',
            ),
            16 => 
            array (
            'id' => 17,
            'stok_awal' => 5,
            'in' => NULL,
            'out' => NULL,
            'pop' => 'G1',
            'created_at' => '2024-11-19 09:42:09',
            'updated_at' => '2024-11-19 09:42:09',
            ),
        ));
        
        
    }
}