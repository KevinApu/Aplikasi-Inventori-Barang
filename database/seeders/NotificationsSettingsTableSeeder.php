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
                'roll' => 5,
                'pack' => 5,
                'unit' => 5,
                'pcs' => 5,
                'pop' => 'G1',
            ),
        ));
        
        
    }
}