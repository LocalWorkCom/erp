<?php

namespace App\Console;

use App\Jobs\UpdateOfferStatuses;
use App\Jobs\UpdateCouponStatuses;
use App\Jobs\UpdateDiscountStatuses;

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
        $schedule->command('offers:update-status')->hourly();
        $schedule->command('coupons:update-status')->hourly();
        $schedule->command('discounts:update-status')->hourly();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected $commands = [
        \App\Console\Commands\UpdateOfferStatusesCommand::class,
        \App\Console\Commands\UpdateDiscountStatusesCommand::class,
        \App\Console\Commands\UpdateDiscountStatusesCommand::class,

    ];
}
