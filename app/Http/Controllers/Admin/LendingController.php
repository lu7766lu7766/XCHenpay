<?php

namespace App\Http\Controllers\Admin;

use App\Authcode;
use App\Repositories\AuthCodes;
use App\Repositories\VerifyCodes;
use Carbon\Carbon;
use Curl\Curl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Response;
use Sentinel;
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
        return view('admin.trade.lendApply');
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

    private function store(Authcode $authCode, $account)
    {
        //只有完成交易可以下發
        //if($authCode->pay_state != 2){
        if($authCode->pay_state == 4){
            $jTableResult = [];
            $jTableResult['Result'] = "error";
            $jTableResult['Message'] = "此订单已申请下发";
            return $jTableResult;
        }else{
            $authCode->pay_state = AuthCodes::lended_state;
            $authCode->pay_summary = AuthCodes::lended_summary;
            $authCode->account = $account;
        }

        if($authCode->save() )
        {
            $jTableResult = [];
            $jTableResult['Result'] = "OK";
            $jTableResult['Record'] = $authCode;
            return $jTableResult;
        }
    }

    public function sendVerifyCode( Request $request, VerifyCodes $verifyCodes)
    {
        $validator = Validator::make( $request->toArray(), [
            'mobile' => 'required'
        ]);

        if ($validator->fails())
        {
            return Response::json(array(
                'Result' => 'error',
                'Message'=> $validator->messages()
            ));
        }

        $data = [
            'mobile'=>$request->mobile,
            'temp_id'=>$this->JIGUANG_tempId,
            "temp_para"=> ["code"=>$randCode = $verifyCodes->generateCode() ]
        ];

        $sendCode = new Curl();
        $sendCode->setBasicAuthentication($this->JIGUANG_appKey, $this->JIGUANG_masterSecret);
        $sendCode->setHeader('Content-Type', 'application/json');
        $sendCode->post('https://api.sms.jpush.cn/v1/messages', json_encode($data));
        $response = $sendCode->response;
//        $response = [];

        if(array_key_exists('error', $response)){
            return $result = ['Result'=>'error', 'Message'=>$response->error->message];
        }else{
            $verifyCode = $verifyCodes->createActiveCode($randCode);
            foreach ($request->id as $id){
                $authCode = Authcode::find($id);
                $verifyCode->attachCode($authCode);
            }

            return $result = [
                'Result'=>'OK',
                'msg_id'=> $randCode
            ];
        }
    }

    public function verify(Request $request, VerifyCodes $verifyCodes)
    {
        $validator = Validator::make( $request->toArray(), [
            'id' => 'required|exists:authcodes,id',
            'code' => 'required',
            'account' => 'required'
        ]);

        if ($validator->fails())
        {
            return Response::json(array(
                'Result' => 'error',
                'Message'=> $validator->messages()
            ));
        }

        $authCode = Authcode::find($request->id);
        $verifyCode = $authCode->verifyCode;

        if($status = $verifyCodes->isActived($verifyCode, $request->code, Carbon::now())){
            $user = Sentinel::getUser();
            activity($user->full_name)
                ->causedBy($user)
                ->log('申請下發订单'.$authCode->trade_seq);
        }

        if($status['Result'] == 'OK')       //申請下發
            return $this::store($authCode, $request->account);
        else
            return $status;                 //回傳錯誤
    }
}
