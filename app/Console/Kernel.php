<?php

namespace App\Console;

use App\Jobs\ActivateOffers;
use App\Jobs\DeactivateExpiredOffers;
use App\Jobs\UpdateOfferStatuses;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('coupons:deactivate-expired')->daily();
        $schedule->job(new UpdateOfferStatuses)->hourly();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
