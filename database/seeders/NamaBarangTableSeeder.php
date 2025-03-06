<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NamaBarangTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('nama_barang')->delete();
        
        DB::table('nama_barang')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama_barang' => 'LAN',
                'pop' => 'G1',
            ),
            1 => 
            array (
                'id' => 2,
                'nama_barang' => 'Fiber Optic',
                'pop' => 'G1',
            ),
            2 => 
            array (
                'id' => 3,
                'nama_barang' => 'Kabel Ties',
                'pop' => 'G1',
            ),
            3 => 
            array (
                'id' => 4,
                'nama_barang' => 'Tp-Link',
                'pop' => 'A1',
            ),
            4 => 
            array (
                'id' => 5,
                'nama_barang' => 'ZTE',
                'pop' => 'A1',
            ),
            5 => 
            array (
                'id' => 6,
                'nama_barang' => 'Adaptor 12v 1A',
                'pop' => 'A1',
            ),
        ));
        
        
    }
}