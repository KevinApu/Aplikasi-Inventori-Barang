<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RekapController;
use Illuminate\Http\Request;

class UpdateRekapBulanan extends Command
{
    // Nama dan deskripsi command
    protected $signature = 'rekap:update';
    protected $description = 'Update rekap bulanan';

    // Menjalankan command
    public function handle()
    {
        $this->info('Rekap bulanan telah diperbarui!');
    }
}
