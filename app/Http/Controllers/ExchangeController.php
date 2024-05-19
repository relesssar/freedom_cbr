<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\СurrencyRate;
use App\Models\СurrencyList;
use AndyDune\CurrencyRateCbr\DailyRate;

class ExchangeController extends Controller
{
    static public function updateRate($date)
    {
        $get_current = СurrencyRate::where('date',$date)->get()->first();
        if (!$get_current) {
            $rate_cbr = new DailyRate();
            $rate_cbr->setDate(new \DateTime($date));

            if ($rate_cbr->retrieve()) {
                $get_list = СurrencyList::all()->toArray();
                foreach ($get_list as $key => $list_item) {
                    $rate = new СurrencyRate();
                    $rate_cbr_currency = $rate_cbr->get($list_item['code']);
                    if ($rate_cbr_currency) {
                        $rate->code = $list_item['code'];
                        $value = $rate_cbr_currency->getValue();
                        $value_float = floatval(str_replace(",", ".", $value)) / floatval($rate_cbr_currency->getNominal());
                        $rate->value = $value_float;
                        $rate->date = $date;
                        $rate->save();
                    }
                }
            } else {
                return false;
            }
            return true;
        }
    }

    public function rate(Request $request)
    {
        $currency = $request->get('currency');
        $date = $request->get('date');
        $basecurrency = $request->get('basecurrency');

        $date_before = date('Y-m-d', strtotime($date. " - 1 day"));

        if ($basecurrency == 'RUB') {
            $get_current = СurrencyRate::whereDate('date', '>=', $date_before)
                ->whereDate('date', '<=', $date)
                ->where('code',$currency)
                ->get()
                ->toArray();
        } else {
            $get_current = СurrencyRate::whereDate('date', '>=', $date_before)
                ->whereDate('date', '<=', $date)
                ->whereIn('code',[$currency])
                ->get()
                ->toArray();
            $get_base = СurrencyRate::whereDate('date', '>=', $date_before)
                ->whereDate('date', '<=', $date)
                ->whereIn('code',[$basecurrency])
                ->get()
                ->toArray();
            $rate_curr = $get_current[0]['value']/$get_base[0]['value'];
            $rate_before = $get_current[1]['value']/$get_base[1]['value'];
            $get_current[0]['value']=$rate_curr;
            $get_current[1]['value']=$rate_before;
        }




        if ($get_current && (count($get_current) == 2)) {
            //$difference = strval(($get_current[0]['value']-$get_current[1]['value'])/100);

            $difference = sprintf("%.12g", ($get_current[0]['value']/$get_current[1]['value']-1)*100);

            $difference_round = round($difference, 2);
            $data = [
                'rate' =>  $get_current[0]['value'],
                'difference'=> $difference_round
            ];
        } else {
            $data = [
                'rate' => 'no data'
            ];
        }


        return response()->json($data);
    }
}
