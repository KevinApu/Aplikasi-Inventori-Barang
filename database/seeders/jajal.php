<?php

namespace Database\Seeders;

use App\Models\BarangMasuk\kategori;
use App\Models\BarangMasuk\nama_barang;
use App\Models\BarangMasukModel;
use App\Models\KLModel;
use App\Models\KLUsers;
use App\Models\popModel;
use App\Models\NotificationSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class jajal extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data untuk kategori
        Kategori::insert([
            [
                'kategori' => 'Kabel',
                'pop' => 'G1'
            ],
            [
                'kategori' => 'Adaptor',
                'pop' => 'G1'
            ],
            [
                'kategori' => 'Router',
                'pop' => 'G1'
            ],
            [
                'kategori' => 'Aksesoris',
                'pop' => 'A1'
            ],
            [
                'kategori' => 'Lainnya',
                'pop' => 'A1'
            ]
        ]);

        // Seed data untuk nama barang
        Nama_Barang::insert([
            [
                'nama_barang' => 'LAN',
                'pop' => 'G1'
            ],
            [
                'nama_barang' => 'Fiber Optic',
                'pop' => 'G1'
            ],
            [
                'nama_barang' => 'Kabel Ties',
                'pop' => 'G1'
            ],
            [
                'nama_barang' => 'Tp-Link',
                'pop' => 'A1'
            ],
            [
                'nama_barang' => 'ZTE',
                'pop' => 'A1'
            ],
            [
                'nama_barang' => 'Adaptor 12v 1A',
                'pop' => 'A1'
            ],
        ]);

        NotificationSetting::insert([
            [
                'id' => 1,
                'roll' => 5,
                'pack' => 5,
                'unit' => 5,
                'pcs' => 5,
                'pop' => 'G1'
            ],
        ]);

        KLModel::insert([
            [
                'id' => 1,
                'pop' => 'G1',
                'kepalakantor' => 'SALSABILLA SALWA I.W., S.Ak',
                'lokasi' => 'PCT',
                'alamat'    => 'Jl P. Sudirman No.3, Barang, Arjowinangun, Kec. Pacitan, Kabupaten Pacitan, Jawa Timur 36516',
                'password_superadmin' => NULL,
            ],
            [
                'id' => 2,
                'pop' => NULL,
                'kepalakantor' => NULL,
                'lokasi' => 'pusat',
                'alamat'    => NULL,
                'password_superadmin' => 'superadmin@sandya.com',
            ],
        ]);

        KLUsers::insert([
            [
            'id' => 1,
            'username' => 'Kevin PKL',
            'password' => 'adminpacitan@sandya.com',
            'role' => 'admin',
            'pop' => 'G1'
            ]
        ]);
    }
}
