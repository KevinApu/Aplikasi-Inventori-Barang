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
                'kategori' => 'Elektronik',
                'pop' => 'G1',
            ),
            1 => 
            array (
                'id' => 2,
                'kategori' => 'Alat Tulis',
                'pop' => 'G1',
            ),
            2 => 
            array (
                'id' => 3,
                'kategori' => 'Perkakas',
                'pop' => 'G1',
            ),
            3 => 
            array (
                'id' => 4,
                'kategori' => 'Kebersihan',
                'pop' => 'G1',
            ),
            4 => 
            array (
                'id' => 5,
                'kategori' => 'Dapur',
                'pop' => 'G1',
            ),
        ));
        
        
    }
}