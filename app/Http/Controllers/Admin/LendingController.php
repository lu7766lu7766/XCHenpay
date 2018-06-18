<?php

namespace App\Http\Controllers\Admin;

use App\Authcode;
use App\Repositories\AuthCodes;
use App\Repositories\VerifyCodes;
use Curl\Curl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Response;
use Illuminate\Support\Facades\DB;

class LendingController extends Controller
{
    private $JIGUANG_appKey, $JIGUANG_masterSecret, $JIGUANG_tempId;

    public function __construct()
    {
        $this->JIGUANG_appKey = '84f050f8af5e75229f6045f8';
        $this->JIGUANG_masterSecret = 'bc51f1100c3a6491384b913b';
        $this->JIGUANG_tempId = '1';
    }

    public function index()
    {
        // Show the page
        return view('admin.trade.lendApply', compact('companies'));
    }

    public function data(Request $request)
    {
        $count = Authcode::all()->count();
        $order = explode(" ", $request->get('jtSorting'));

        if($request->trade_service_id){
            $data = Authcode::where('trade_service_id',$request->trade_service_id)->orderBy($order[0], $order[1])
                ->take($request->get('jtPageSize'))
                ->skip($request->get('jtStartIndex'))
                ->get()->toArray();
        }
        else{
            $data = Authcode::orderBy($order[0], $order[1])
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

    public function store( Request $request)
    {
        $data = Authcode::find($request->id);
        if($data->pay_state == 4){
            info($data);
            $jTableResult = [];
            $jTableResult['Result'] = "error";
            $jTableResult['Message'] = "此订单已申请下发";
            return $jTableResult;
        }else{
            $data->pay_state = 4;
            $data->pay_summary = '申请下发';
        }

        if($data->save() )
        {
            info($data);
            $jTableResult = [];
            $jTableResult['Result'] = "OK";
            $jTableResult['Record'] = $data;
            return $jTableResult;
        }
    }

    public function sendVerifyCode( Request $request, VerifyCodes $verifyCodes)
    {
        $data = [
            'mobile'=>$request->mobile,
            'temp_id'=>$this->JIGUANG_tempId,
            "temp_para"=> ["code"=>$randCode = $verifyCodes->generateCode() ]
        ];

        $sendCode = new Curl();
        $sendCode->setBasicAuthentication($this->JIGUANG_appKey, $this->JIGUANG_masterSecret);
        $sendCode->setHeader('Content-Type', 'application/json');
//        $sendCode->post('https://api.sms.jpush.cn/v1/messages', json_encode($data));
//        $response = $sendCode->response;
        $response = [];

        if(array_key_exists('error', $response)){
            return $result = ['Result'=>'error', 'Message'=>$response->error->message];
        }else{
            //todo: add $randCode to specific rows
            $verifyCode = $verifyCodes->createActiveCode($randCode);
            $authCode = Authcode::find($request->id);
            $verifyCode->attachCode($authCode);
            dd($authCode->verifyCode->id);

            return $result = [
                'Result'=>'OK',
//                'msg_id'=>$response->msg_id
                'msg_id'=> $randCode
            ];
        }
    }
}
