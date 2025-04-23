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
                'nama_barang' => 'Kipas Angin',
                'pop' => 'G1',
            ),
            1 => 
            array (
                'id' => 2,
                'nama_barang' => 'Pulpen',
                'pop' => 'G1',
            ),
            2 => 
            array (
                'id' => 3,
                'nama_barang' => 'Obeng Set',
                'pop' => 'G1',
            ),
            3 => 
            array (
                'id' => 4,
                'nama_barang' => 'Tisu Gulung',
                'pop' => 'G1',
            ),
            4 => 
            array (
                'id' => 5,
                'nama_barang' => 'Dispenser Air',
                'pop' => 'G1',
            ),
            5 => 
            array (
                'id' => 6,
                'nama_barang' => 'Masker',
                'pop' => 'G1',
            ),
        ));
        
        
    }
}