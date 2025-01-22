<?php

namespace App\Console;

use App\Http\Controllers\RekapController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Http\Request;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('rekap:update')->monthlyOn(1, '00:00');
    }
    

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        // Memuat perintah artisan dari folder Commands
        $this->load(__DIR__.'/Commands');

        // Memuat perintah artisan custom dari routes/console.php
        require base_path('routes/console.php');
    }
}
