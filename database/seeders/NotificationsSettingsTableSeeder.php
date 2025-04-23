<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('notifications_settings')->delete();
    
        DB::table('notifications_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'roll' => 10,
                'pack' => 10,
                'unit' => 10,
                'pcs' => 10,
                'pop' => 'G1',
            ),
        ));
        
        
    }
}