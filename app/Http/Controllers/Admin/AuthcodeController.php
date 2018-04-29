<?php

namespace App\Http\Controllers\Admin;

use App\Authcode;
use function compact;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AuthcodeController extends Controller
{
    public function index(){
        $authCodes = Authcode::all();

        foreach($authCodes as $key => $log){
            $paymentName = DB::table('payments')->where('i6pay_id', $log['payment_type'])->value('name');
            $authCodes[$key]['payment_type'] = $paymentName;

            $currencyName = DB::table('currencies')->where('id', $log['currency'])->value('name');
            $authCodes[$key]['currency'] = $currencyName;
        }

        return view('admin.authcode.index', compact('authCodes'));
    }
}
