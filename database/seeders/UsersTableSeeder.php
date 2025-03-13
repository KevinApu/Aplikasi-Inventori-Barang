<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('users')->delete();
        
        DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'Kevin PKL',
                'password' => 'adminpacitan@sandya.com',
                'role' => 'admin',
                'request_access' => 0,
                'foto' => NULL,
                'created_at' => NULL,
                'updated_at' => '2025-03-14 02:32:41',
                'last_login' => '2025-03-14 02:32:41',
                'pop_id' => 'G1',
            ),
            1 => 
            array (
                'id' => 2,
                'username' => 'superadmin',
                'password' => 'superadmin@sandya.com',
                'role' => 'superadmin',
                'request_access' => 0,
                'foto' => NULL,
                'created_at' => NULL,
                'updated_at' => '2025-03-14 02:35:35',
                'last_login' => '2025-03-14 02:35:22',
                'pop_id' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'username' => 'Dio',
                'password' => 'adminponorogo@sandya.com',
                'role' => 'admin',
                'request_access' => 0,
                'foto' => NULL,
                'created_at' => '2025-03-14 02:47:56',
                'updated_at' => '2025-03-14 02:48:50',
                'last_login' => '2025-03-14 02:48:50',
                'pop_id' => 'A1',
            ),
        ));
        
        
    }
}