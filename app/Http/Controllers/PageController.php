<?php

namespace App\Http\Controllers;

use App\Models\СurrencyList;
use App\Models\СurrencyRate;
use Illuminate\Http\Request;
use AndyDune\CurrencyRateCbr\DailyRate;
use AndyDune\CurrencyRateCbr\Currency;
use App\Http\Controllers\ExchangeController;
class PageController extends Controller
{
    public function welcome()
    {
        $get_list = СurrencyList::all()->toArray();
        $data = [];
        foreach ($get_list as $currency) {
            $data[$currency['code']]=$currency['code'];
        }

        return view('welcome',[
            'currency'=>$data
        ]);
    }
}
