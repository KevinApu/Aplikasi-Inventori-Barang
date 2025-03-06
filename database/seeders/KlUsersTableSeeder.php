<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('kl_users')->delete();
        
        DB::table('kl_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'Kevin PKL',
                'password' => 'adminpacitan@sandya.com',
                'role' => 'admin',
                'pop' => 'G1',
            ),
        ));
        
        
    }
}