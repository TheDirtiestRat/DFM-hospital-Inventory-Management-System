<?php

namespace App\Console;



use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\NewPatient;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // deletes old records everyday
        // $schedule->command('model:prune')->hourly();
        $schedule->command('model:prune')->daily();

        // checks the expired medicines
        $schedule->call(function () {
            dd('this is a tesk schedule');
            // $users = User::all();
            // Notification::send($users, new NewPatient(1, 'testing'));

            // DB::table('patient_cases')->delete();
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
