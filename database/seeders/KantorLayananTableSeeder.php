<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KantorLayananTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('kantor_layanan')->delete();
    
        DB::table('kantor_layanan')->insert(array (
            0 => 
            array (
                'pop' => 'A1',
                'lokasi' => 'PNG',
                'alamat' => 'Ponorogo Kota',
            ),
            1 => 
            array (
                'pop' => 'G1',
                'lokasi' => 'PCT',
                'alamat' => 'Jl. Letjend Soeprapto No.53, Barean, Ploso, Kec. Pacitan, Kabupaten Pacitan, Jawa Timur 63515',
            ),
        ));
        
        
    }
}