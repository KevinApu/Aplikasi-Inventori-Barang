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
            6 => 
            array (
                'id' => 7,
                'nama_barang' => 'Kulkas Mini',
                'pop' => 'G1',
            ),
            7 => 
            array (
                'id' => 8,
                'nama_barang' => 'Pensil',
                'pop' => 'G1',
            ),
            8 => 
            array (
                'id' => 9,
                'nama_barang' => 'Gergaji Besi',
                'pop' => 'G1',
            ),
            9 => 
            array (
                'id' => 10,
                'nama_barang' => 'Sabun Cair',
                'pop' => 'G1',
            ),
            10 => 
            array (
                'id' => 11,
                'nama_barang' => 'Pembersih Lantai',
                'pop' => 'G1',
            ),
            11 => 
            array (
                'id' => 12,
                'nama_barang' => 'Televisi 32"',
                'pop' => 'G1',
            ),
            12 => 
            array (
                'id' => 13,
                'nama_barang' => 'Palu',
                'pop' => 'G1',
            ),
            13 => 
            array (
                'id' => 14,
                'nama_barang' => 'Mesin Cuci Piring',
                'pop' => 'G1',
            ),
            14 => 
            array (
                'id' => 15,
                'nama_barang' => 'Laptop',
                'pop' => 'G1',
            ),
            15 => 
            array (
                'id' => 16,
                'nama_barang' => 'Pembersih Kaca',
                'pop' => 'G1',
            ),
            16 => 
            array (
                'id' => 17,
                'nama_barang' => 'AC Split',
                'pop' => 'G1',
            ),
            17 => 
            array (
                'id' => 18,
                'nama_barang' => 'Marker',
                'pop' => 'G1',
            ),
            18 => 
            array (
                'id' => 19,
                'nama_barang' => 'Tang',
                'pop' => 'G1',
            ),
            19 => 
            array (
                'id' => 20,
                'nama_barang' => 'Blender',
                'pop' => 'G1',
            ),
        ));
        
        
    }
}