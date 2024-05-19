<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\СurrencyRate;

class UpdCurrencyRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:upd-currency-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Curency Rate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dates = 180;

        for ($i = 0; $i <= $dates-1; $i++) { // classic loop :)
            $thisDate = date('Y-m-d');
            $date_str = date('Y-m-d', strtotime($thisDate. " - ".$i." day"));
            $get_current = СurrencyRate::where('date',$date_str)->get()->first();
            if (!$get_current) {
                $job = new \App\Jobs\JobCurency($date_str);
                dispatch($job)->onQueue('default');
            }
        }
        // Delete older than number $dates
        $thisDate = date('Y-m-d');
        $date_str = date('Y-m-d', strtotime($thisDate. " - ".($dates++)." day"));
        СurrencyRate::where('date', '<=', $date_str)->each(function ($item) {
            $item->delete();
        });
    }
}
