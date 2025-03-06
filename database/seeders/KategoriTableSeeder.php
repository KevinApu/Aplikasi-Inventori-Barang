<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('kategori')->delete();
        
        DB::table('kategori')->insert(array (
            0 => 
            array (
                'id' => 1,
                'kategori' => 'Kabel',
                'pop' => 'G1',
            ),
            1 => 
            array (
                'id' => 2,
                'kategori' => 'Adaptor',
                'pop' => 'G1',
            ),
            2 => 
            array (
                'id' => 3,
                'kategori' => 'Router',
                'pop' => 'G1',
            ),
            3 => 
            array (
                'id' => 4,
                'kategori' => 'Aksesoris',
                'pop' => 'A1',
            ),
            4 => 
            array (
                'id' => 5,
                'kategori' => 'Lainnya',
                'pop' => 'A1',
            ),
        ));
        
        
    }
}