<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Ši komanda bus paleidžiama kas minutę
        $schedule->command('cancel:expired-reservations')->everyMinute();
    }

    protected function commands(): void
    {
        // Būtina, kad Laravel rastų visas komandas
        $this->load(__DIR__.'/Commands');
    }
}
