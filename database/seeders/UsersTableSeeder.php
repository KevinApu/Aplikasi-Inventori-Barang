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
                'username' => 'kevin',
                'password' => 'admingudang1',
                'role' => 'admin',
                'request_access' => 0,
                'foto' => 'img/profile/68087de709852.jpg',
                'created_at' => NULL,
                'updated_at' => '2025-04-23 12:49:54',
                'last_login' => '2025-04-23 12:49:54',
                'pop_id' => 'G1',
            ),
            1 => 
            array (
                'id' => 2,
                'username' => 'superadmin',
                'password' => 'superadmin123',
                'role' => 'superadmin',
                'request_access' => 0,
                'foto' => NULL,
                'created_at' => NULL,
                'updated_at' => '2025-04-23 12:48:02',
                'last_login' => '2025-04-23 12:48:02',
                'pop_id' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'username' => 'kevin user',
                'password' => 'usergudang1',
                'role' => 'admin',
                'request_access' => 0,
                'foto' => NULL,
                'created_at' => '2025-03-14 02:47:56',
                'updated_at' => '2025-03-14 02:48:50',
                'last_login' => '2025-03-14 02:48:50',
                'pop_id' => 'G1',
            ),
        ));
        
        
    }
}