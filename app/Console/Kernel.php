<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        //Commands\WordOfTheDay::class,
       // Commands\WeekDay::class,
      //  Commands\Stra::class,
       // Commands\Intervient::class,
       // Commands\UpdateAction::class,
       // Commands\J2::class,
        Commands\ExecuteCodeProducteur::class,
        //Commands\ExecuteProducteurTest::class,
       // Commands\ExecuteCodeIntrantEquipement::class,
        //Commands\ExecuteCodeIntrantEquipement2::class,
        Commands\ExecuteCodeIntrantEquipementBackup::class,
        Commands\ExecuteCodeParcelle::class,
        Commands\ExecuteCodeScoop::class,
        Commands\ExecuteCodeVisitePracitisme::class,
        Commands\Helpdesk::class,
        Commands\UpdateSection::class,
        Commands\ExecuteCodeHauteur::class,
        Commands\ExecuteCodeProducteurIndividuel::class,
        Commands\ExecuteCodeIntrantEquipementIndividuel::class,
        Commands\ExecuteCodeFormation::class,
        Commands\ExecuteCodeDetailScoop::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       //$schedule->command('word:day')->everyMinute();
              $schedule->command('execute:producteur')->everyMinute();
              $schedule->command('execute:producteurTest')->everyFiveMinutes();
              //->daily()->at('23:00');
             // $schedule->command('execute:intrant')->everyFiveMinutes();
             // $schedule->command('execute:intrant2')->everyFiveMinutes();
              $schedule->command('execute:intrantbackup')->everyMinute();
             // $schedule->command('execute:intrantbackup') ->cron('*/20 * * * *');
             // $schedule->command('execute:intrant')->everyThirtyMinutes();
              //->daily()->at('23:00');
              $schedule->command('execute:scoop')->everyFiveMinutes();
              //->daily()->at('23:00');
              $schedule->command('execute:pracitisme')->everyFiveMinutes();
              //->daily()->at('23:00');
              $schedule->command('execute:parcelle')->everyFiveMinutes();
              $schedule->command('help:desk')->everyFiveMinutes();
              $schedule->command('update:section')->everyMinute();
              $schedule->command('execute:producteur_individuel')->everyFiveMinutes();
              $schedule->command('execute:intrant_individuel')->everyFiveMinutes();
              $schedule->command('execute:hauteur')->everyFiveMinutes();
              $schedule->command('execute:formation')->everyFiveMinutes();
              $schedule->command('execute:detail_scoop')->everyFiveMinutes();
              //->daily()->at('23:00');
             // $schedule->command('word:day')->mondays()->at('07:00');
             // $schedule->command('week:day')->sundays()->at('15:30');
              //$schedule->command('stra:update')->sundays()->at('23:15');
              //->everyMinute();
           // $schedule->command('week:day')->fridays()->at('15:30');
              //$schedule->command('j2:day')->everyMinute();
        //   $schedule->command('word:day')->everyMinute();
          
          //$schedule->command('update:action')->dailyAt('08:00');
        
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
