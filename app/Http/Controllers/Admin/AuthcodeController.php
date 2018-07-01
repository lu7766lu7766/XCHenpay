<?php

namespace App\Http\Controllers\Admin;

use Sentinel;
use App\Authcode;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AuthcodeController extends Controller
{
    public function index(){
        $authCodes = Authcode::where('company_service_id', '=', Sentinel::getUser()->company_service_id)->get();

        foreach($authCodes as $key => $log){
            $paymentName = DB::table('payments')->where('i6pay_id', $log['payment_type'])->value('name');
            $authCodes[$key]['payment_type'] = $paymentName;

            $currencyName = DB::table('currencies')->where('id', $log['currency_id'])->value('name');
            $authCodes[$key]['currency'] = $currencyName;
        }

        return view('admin.trade.logQuery', compact('authCodes'));
    }
}
