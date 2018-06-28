<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\AuthCodes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Authcode;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Validator;
use Response;

class LendManageController extends Controller
{
    public function index()
    {
        // Show the page
        return view('admin.trade.lendManage');
    }

    public function data(Request $request)
    {
        $count = Authcode::all()->count();
        $order = explode(" ", $request->get('jtSorting'));

        if($request->trade_service_id){
            $data = Authcode::where('pay_state', AuthCodes::lended_state)
                ->where('trade_service_id',$request->trade_service_id)->orderBy($order[0], $order[1])
                ->take($request->get('jtPageSize'))
                ->skip($request->get('jtStartIndex'))
                ->get()->toArray();
        }
        else{
            $data = Authcode::where('pay_state', AuthCodes::lended_state)
                ->orderBy($order[0], $order[1])
                ->take($request->get('jtPageSize'))
                ->skip($request->get('jtStartIndex'))
                ->get()->toArray();
        }

        foreach($data as $key => $log){
            $paymentName = DB::table('payments')->where('i6pay_id', $log['payment_type'])->value('name');
            $data[$key]['payment_type'] = $paymentName;

            $currencyName = DB::table('currencies')->where('id', $log['currency_id'])->value('name');
            $data[$key]['currency'] = $currencyName;
        }

        return Response::json(array(
            'Result' => 'OK',
            'TotalRecordCount' => $count,
            'Records' => $data
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make( $request->toArray(), [
            'id' => 'required|exists:authcodes,id',
            'operation' => 'required|in:0,1',
        ]);

        if ($validator->fails())
        {
            return Response::json(array(
                'Result' => 'error',
                'Message'=> $validator->messages()
            ));
        }

        $authCode = Authcode::find($request->id);

        //訂單下申請狀態不能作管理
        if($authCode->pay_state != 4){
            return Response::json(array(
                'Result' => 'error',
                'Message'=> '此单非申请下发状态，请重新整理后再次尝试'
            ));
        }

        $user = Sentinel::getUser();

        if($request->operation){
            $authCode->update(['pay_state' => AuthCodes::accept_state, 'pay_summary' => AuthCodes::accept_summary]);

            activity($user->full_name)
                ->causedBy($user)
                ->log('准許下发了订单'.$authCode->trade_seq);
        }
        else{
            $authCode->update(['pay_state' => AuthCodes::deny_state, 'pay_summary' => AuthCodes::deny_summary]);

            activity($user->full_name)
                ->causedBy($user)
                ->log('拒絕下發了订单'.$authCode->trade_seq);
        }

        return Response::json(array(
            'Result' => 'OK'
        ));
    }
}
