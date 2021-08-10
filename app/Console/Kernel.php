<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\createNotifications'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule){
//        $schedule->call(function(){
//            DB::table('sluzbenici')->insert(
//              [
//                  'ime' => "aladin",
//                  'prezime' => "Kapic"
//              ]
//            );
//        });



        $schedule->command('create:Notifications')->everyMinute();
        $schedule->command('workplace:no-of-employees')->dailyAt('01:00');
//        $schedule->command('create:TryCommand')->everyMinute();

        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(){
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
