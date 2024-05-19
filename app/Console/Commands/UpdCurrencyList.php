<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\СurrencyList;
use AndyDune\CurrencyRateCbr\Currency;

class UpdCurrencyList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:upd-currency-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currency list';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        СurrencyList::truncate();
        $currencies = new Currency();
        $currency_list = $currencies->retrieve();

        foreach ($currency_list as $key => $item) {
            if ($key !== '') {
                $newlist = new СurrencyList();
                $newlist->code = $key;
                $newlist->name = $item;
                $newlist->save();
            }
        }
    }
}
