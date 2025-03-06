<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangRusakTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('barang_rusak')->delete();
        
        DB::table('barang_rusak')->insert(array (
            0 => 
            array (
                'id' => 1,
                'jumlah' => 1,
                'input_by' => 'kevin pkl',
                'foto' => 'img/1741253606-S0MnbzPZrA4UH9066cOdzt9Lcav3kFldupBzLepj.png',
                'kondisi' => 'Putus',
                'penyebab' => 'Dibacok Polisi',
                'pop' => 'G1',
                'qr_code' => 'd58ff817aa32432c92a9ecfd29c6b3f6',
                'status' => 'rusak_sesudah_penggunaan',
                'stok_gudang_id' => 1,
                'created_at' => '2025-03-06 16:33:26',
                'updated_at' => '2025-03-06 16:33:26',
            ),
        ));
        
        
    }
}