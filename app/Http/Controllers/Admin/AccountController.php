<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\VerifyCodes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Account;
use Curl\Curl;
use App\User;
use Validator;
use Sentinel;
use Response;

class AccountController extends Controller
{
    private $JIGUANG_appKey, $JIGUANG_masterSecret, $JIGUANG_tempId;

    public function __construct()
    {
        $this->JIGUANG_appKey = '84f050f8af5e75229f6045f8';
        $this->JIGUANG_masterSecret = 'bc51f1100c3a6491384b913b';
        $this->JIGUANG_tempId = '1';
    }

    public function getModalDelete(Account $account)
    {
        $model = 'account';

        $error = null;

        $confirm_route = route('admin.account.delete', ['id' => $account->id]);

        return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function destroy(Account $account)
    {
        $account->delete();

        $user = Sentinel::getUser();
        activity($user->full_name)
            ->performedOn($user)
            ->causedBy($user)
            ->log('取消绑订了一笔帐户');

        return back();
    }

    public function sendVerifyCode( Request $request, VerifyCodes $verifyCodes)
    {
        $validator = Validator::make( $request->toArray(), [
            'id'     => 'required|exists:users,id',
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
            $user = User::find($request->id);
            $user->attachCode($verifyCode);

            return $result = [
                'Result'=>'OK',
                'msg_id'=> $randCode
            ];
        }
    }

    public function verify(Request $request, VerifyCodes $verifyCodes)
    {
        $validator = Validator::make($request->toArray(), [
            'id' => 'required|exists:users,id',
            'code' => 'required',
            'account' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'Result' => 'error',
                'Message' => $validator->messages()
            ));
        }

        $user = User::find($request->id);
        $verifyCode = $user->verifyCodes()->where('code', $request->code)->first();

        $result = $verifyCodes->codeValidate($verifyCode, $request->code, Carbon::now());

        if ($result['Result'] == 'OK') {    //綁定帳號
            if($user->accounts->count() < 10){
                $user->addAccount(new Account(['account' => $request->account]));

                activity($user->full_name)->causedBy($user)->log('绑订了一笔帐号');

                return $result;
            }else{
                return Response::json(array(
                    'Result' => 'error',
                    'Message' => '此商户已绑订10组帐号，请删除就有帐号后重试'
                ));
            }
        }
        else
            return $result;                 //回傳錯誤
    }
}

