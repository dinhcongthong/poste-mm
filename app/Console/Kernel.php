<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DB;

use App\Mail\ExpiredAdminMail;

class Kernel extends ConsoleKernel
{
    /**
    * The Artisan commands provided by your application.
    *
    * @var array
    */
    protected $commands = [
        //
    ];

    /**
    * Define the application's command schedule.
    *
    * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
    * @return void
    */
    protected function schedule(Schedule $schedule)
    {
        // Set Cronjob to Check Expired Ad
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $schedule->call(function() use($yesterday) {
            $ad_expired_list = DB::table('ads')->where('inform_sale', 1)->whereDate('end_date', $yesterday)->get();

            DB::table('ads')->where('inform_sale', 1)->whereDate('end_date', $yesterday)->update([
                'inform_sale' => 0,
                'note' => 'Auto Hidden because expired'
            ]);

            $business_list = DB::table('businesses')->where('fee', 1)->whereDate('end_date', $yesterday)->get();

            $town_list = DB::table('poste_towns')->where('fee', 1)->whereDate('end_date', $yesterday)->get();

            if(!$town_list->isEmpty() || !$business_list->isEmpty() || !$ad_expired_list->isEmpty()) {
                Mail::to('nvnhan@poste-vn.com')->send(new ExpiredAdminMail($ad_expired_list, $business_list, $town_list));
            }
        })->daily();
    }

    /**
    * Get the timezone that should be used by default for scheduled events.
    *
    * @return \DateTimeZone|string|null
    */
    protected function scheduleTimezone()
    {
        return 'Asia/Yangon';
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
