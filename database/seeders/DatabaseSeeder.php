<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $this->call(StokGudangTableSeeder::class);
        $this->call(RekapTableSeeder::class);
        $this->call(NotificationsSettingsTableSeeder::class);
        $this->call(NamaBarangTableSeeder::class);
        $this->call(KategoriTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(KantorLayananTableSeeder::class);
        $this->call(BarangRusakTableSeeder::class);
        $this->call(BarangKeluarTableSeeder::class);
    }
}
