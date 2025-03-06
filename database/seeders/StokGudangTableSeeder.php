<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokGudangTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('stok_gudang')->delete();
        
        DB::table('stok_gudang')->insert(array (
            0 => 
            array (
                'id' => 1,
                'kode_barang' => '222',
                'kategori' => 'Router',
                'nama_barang' => 'Fiber Optic',
                'seri' => '-',
                'jumlah' => 5,
                'satuan' => 'pcs',
                'rasio' => NULL,
                'hasil' => NULL,
                'detail_jumlah' => NULL,
                'lokasi' => 'Rak Bawah',
                'foto' => 'img/1741250048-JYOFzWM842TsZAC6BJwKSNM40X8U3X2yqujfJRaQ.png',
                'input_by' => 'kevin pkl',
                'keterangan' => NULL,
                'pop' => 'G1',
                'created_at' => '2025-03-06 15:34:08',
                'updated_at' => '2025-03-06 16:32:32',
            ),
            1 => 
            array (
                'id' => 2,
                'kode_barang' => '6756',
                'kategori' => 'Kabel',
                'nama_barang' => 'LAN',
                'seri' => '-',
                'jumlah' => 2,
                'satuan' => 'roll',
                'rasio' => 100,
                'hasil' => 198,
                'detail_jumlah' => 98,
                'lokasi' => 'Rak 2',
                'foto' => 'img/1741251615-CN5uVsaFLhMHkp2PrhBOXydDkRPsW5rIzW38KxGS.jpg',
                'input_by' => 'kevin pkl',
                'keterangan' => NULL,
                'pop' => 'G1',
                'created_at' => '2025-03-06 16:00:15',
                'updated_at' => '2025-03-06 16:31:46',
            ),
        ));
        
        
    }
}