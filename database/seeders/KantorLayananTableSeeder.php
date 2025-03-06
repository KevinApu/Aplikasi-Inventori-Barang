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
                'id' => 1,
                'pop' => 'G1',
                'lokasi' => 'PCT',
                'alamat' => 'Jl P. Sudirman No.3, Barang, Arjowinangun, Kec. Pacitan, Kabupaten Pacitan, Jawa Timur 36516',
                'password_superadmin' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'pop' => NULL,
                'lokasi' => 'pusat',
                'alamat' => NULL,
                'password_superadmin' => 'superadmin@sandya.com',
            ),
        ));
        
        
    }
}