<?php

namespace Database\Seeders;

use App\Models\BarangMasukModel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        BarangMasukModel::insert([
            [
                'kode_barang' => 'R01',
                'kategori' => 'Router',
                'nama_barang' => 'ZTE',
                'seri' => 'F660',
                'jumlah' => 15,
                'satuan' => 'unit',
                'lokasi' => 'Rak 2',
                'foto' => 'img/1728271328-8ac0IiIZp9xjN6KuVKtd054NrDiLFG8QKJK5Tddn.jpg',
                'input_by' => 'Budiono Siregar',
            ],
            [
                'kode_barang' => 'A01',
                'kategori' => 'Aksesoris',
                'nama_barang' => 'Kabel Ties',
                'seri' => '15cm Hijau',
                'jumlah' => 10,
                'satuan' => 'pack',
                'lokasi' => 'Rak 2',
                'foto' => 'img/1728271328-8ac0IiIZp9xjN6KuVKtd054NrDiLFG8QKJK5Tddn.jpg',
                'input_by' => 'Budiono Siregar',
            ],
            [
                'kode_barang' => 'K02',
                'kategori' => 'Kabel',
                'nama_barang' => 'Fiber Optic',
                'seri' => 'C21',
                'jumlah' => 3,
                'satuan' => 'roll',
                'lokasi' => 'Rak bawah',
                'foto' => 'img/1728271328-8ac0IiIZp9xjN6KuVKtd054NrDiLFG8QKJK5Tddn.jpg',
                'input_by' => 'Budiono Siregar',
            ],
            [
                'kode_barang' => 'K03',
                'kategori' => 'Kabel',
                'nama_barang' => 'Fiber Optic',
                'seri' => 'C21',
                'jumlah' => 3,
                'satuan' => 'roll',
                'lokasi' => 'Rak bawah',
                'foto' => 'img/1728271328-8ac0IiIZp9xjN6KuVKtd054NrDiLFG8QKJK5Tddn.jpg',
                'input_by' => 'Budiono Siregar',
            ],
            [
                'kode_barang' => 'K04',
                'kategori' => 'Kabel',
                'nama_barang' => 'Fiber Optic',
                'seri' => 'C21',
                'jumlah' => 3,
                'satuan' => 'roll',
                'lokasi' => 'Rak bawah',
                'foto' => 'img/1728271328-8ac0IiIZp9xjN6KuVKtd054NrDiLFG8QKJK5Tddn.jpg',
                'input_by' => 'Budiono Siregar',
            ],
            [
                'kode_barang' => 'K05',
                'kategori' => 'Kabel',
                'nama_barang' => 'Fiber Optic',
                'seri' => 'C21',
                'jumlah' => 3,
                'satuan' => 'roll',
                'lokasi' => 'Rak bawah',
                'foto' => 'img/1728271328-8ac0IiIZp9xjN6KuVKtd054NrDiLFG8QKJK5Tddn.jpg',
                'input_by' => 'Budiono Siregar',
            ],[
                'kode_barang' => 'R022',
                'kategori' => 'Router',
                'nama_barang' => 'ZTE',
                'seri' => 'Inkjsdn',
                'jumlah' => 15,
                'satuan' => 'unit',
                'lokasi' => 'Rak 2',
                'foto' => 'img/1728271328-8ac0IiIZp9xjN6KuVKtd054NrDiLFG8QKJK5Tddn.jpg',
                'input_by' => 'Budiono Siregar',
            ],[
                'kode_barang' => 'R07',
                'kategori' => 'Router',
                'nama_barang' => 'ZTaaE',
                'seri' => 'F66gjkg0',
                'jumlah' => 15,
                'satuan' => 'unit',
                'lokasi' => 'Rak 2',
                'foto' => 'img/1728271328-8ac0IiIZp9xjN6KuVKtd054NrDiLFG8QKJK5Tddn.jpg',
                'input_by' => 'Budiono Siregar',
            ],[
                'kode_barang' => 'A0111',
                'kategori' => 'Aksesoris',
                'nama_barang' => 'Kabel Ties',
                'seri' => '15cm Hijauadasd',
                'jumlah' => 10,
                'satuan' => 'pack',
                'lokasi' => 'Rak 2',
                'foto' => 'img/1728271328-8ac0IiIZp9xjN6KuVKtd054NrDiLFG8QKJK5Tddn.jpg',
                'input_by' => 'Budiono Siregar',
            ],[
                'kode_barang' => 'A088',
                'kategori' => 'Aksesoris',
                'nama_barang' => 'Kabel Ties',
                'seri' => '15cm asdas',
                'jumlah' => 10,
                'satuan' => 'pack',
                'lokasi' => 'Rak 2',
                'foto' => 'img/1728271328-8ac0IiIZp9xjN6KuVKtd054NrDiLFG8QKJK5Tddn.jpg',
                'input_by' => 'Budiono Siregar',
            ],[
                'kode_barang' => 'A022',
                'kategori' => 'Aksesoris',
                'nama_barang' => 'Kabel Ties',
                'seri' => '200cm Hijau',
                'jumlah' => 10,
                'satuan' => 'pack',
                'lokasi' => 'Rak 2',
                'foto' => 'img/1728271328-8ac0IiIZp9xjN6KuVKtd054NrDiLFG8QKJK5Tddn.jpg',
                'input_by' => 'Budiono Siregar',
            ],
        ]);
        $this->call(BarangMasukTableSeeder::class);
        $this->call(RekapTableSeeder::class);
        $this->call(StokGudangTableSeeder::class);
    }
}
