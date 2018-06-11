<?php

namespace App\Http\Controllers\Admin;

use App\Authcode;
use App\Datatable;
use App\Jtable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Illuminate\Support\Facades\DB;

class LendingController extends Controller
{
    public function index()
    {
        // Show the page
        return view('admin.trade.lendApply', compact('companies'));
    }

    public function data(Request $request)
    {
        $count = Authcode::all()->count();
        $order = explode(" ", $request->get('jtSorting'));

        if($request->firstname && $request->lastname == ''){
            $data = Datatable::where('firstname',$request->firstname)->orderBy($order[0], $order[1])
                ->take($request->get('jtPageSize'))
                ->skip($request->get('jtStartIndex'));
        }else if($request->firstname == '' && $request->lastname){
            $data = Datatable::where('lastname',$request->lastname)->orderBy($order[0], $order[1])
                ->take($request->get('jtPageSize'))
                ->skip($request->get('jtStartIndex'));
        }
        else if($request->firstname && $request->lastname){
            $data = Datatable::where('firstname',$request->firstname)->where('lastname',$request->lastname)->orderBy($order[0], $order[1])
                ->take($request->get('jtPageSize'))
                ->skip($request->get('jtStartIndex'));
        }
        else{
            $data = Authcode::orderBy($order[0], $order[1])
                ->take($request->get('jtPageSize'))
                ->skip($request->get('jtStartIndex'))
                ->get()->toArray();

            foreach($data as $key => $log){
                $paymentName = DB::table('payments')->where('i6pay_id', $log['payment_type'])->value('name');
                $data[$key]['payment_type'] = $paymentName;

                $currencyName = DB::table('currencies')->where('id', $log['currency_id'])->value('name');
                $data[$key]['currency'] = $currencyName;
            }
        }

        return Response::json(array(
            'Result' => 'OK',
            'TotalRecordCount' => $count,
            'Records' => $data
        ));
    }
}
