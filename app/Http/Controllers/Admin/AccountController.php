<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Repositories\VerifyCodes;
use App\User;
use Carbon\Carbon;
use Curl\Curl;
use Illuminate\Http\Request;
use Sentinel;
use Validator;
use Yajra\DataTables\DataTables;

class AccountController extends Controller
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
        $companies = User::All()->where('company_service_id', '<>', null);

        return view('admin.users.accountList', compact('companies'));
    }

    public function createAccount()
    {
        $user = Sentinel::getUser();

        return view('admin.users.addAccount', compact('user'));
    }

    public function accountData()
    {
        if (!isset(request()->id) || request()->id == null) {
            return $this->makeAccountTable([]);
        };
        $user = User::find(request()->id);
        $accounts = $user->accounts;

        return $this->makeAccountTable($accounts);
    }

    private function makeAccountTable($accounts)
    {
        return DataTables::of($accounts)
            ->editColumn('created_at', function (Account $account) {
                return $account->created_at->diffForHumans();
            })
            ->addColumn('actions', function ($account) {
                $deleteLink = '<a href=' . route('admin.account.confirm-delete',
                        $account->id) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="user-remove" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title=' . trans('users/ViewProfile/form.deleteAccount') . '></i></a>';

                return $deleteLink;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getAccountDelete(Account $account)
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
        activity($user->email)
            ->performedOn($user)
            ->causedBy($user)
            ->log('取消绑订了一笔帐户');

        return back();
    }

    public function sendVerifyCode(Request $request, VerifyCodes $verifyCodes)
    {
        $messages = [
            'mobile.required' => '此帐户未绑定联络电话',
            'exists'          => '此帐号不存在，请刷新页面后重试.',
        ];
        $validator = Validator::make($request->toArray(), [
            'id'     => 'required|exists:users,id',
            'mobile' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return $this->validateErrorResponseInJson($validator);
        }
        $data = [
            'mobile'    => $request->mobile,
            'temp_id'   => $this->JIGUANG_tempId,
            "temp_para" => ["code" => $randCode = $verifyCodes->generateCode()]
        ];
        $sendCode = new Curl();
        $sendCode->setBasicAuthentication($this->JIGUANG_appKey, $this->JIGUANG_masterSecret);
        $sendCode->setHeader('Content-Type', 'application/json');
        $sendCode->post('https://api.sms.jpush.cn/v1/messages', json_encode($data));
        $response = $sendCode->response;
//        $response = [];
        if (array_key_exists('error', $response)) {
            return $result = ['Result' => 'error', 'Message' => $response->error->message];
        } else {
            $verifyCode = $verifyCodes->createActiveCode($randCode);
            $user = User::find($request->id);
            $user->attachCode($verifyCode);

            return $result = [
                'Result' => 'OK',
                'msg_id' => $randCode
            ];
        }
    }

    public function addAccount(Request $request, VerifyCodes $verifyCodes)
    {
        $messages = [
            'required' => ':attribute 是必填资讯.',
            'exists'   => '此验证码不存在，请重新尝试或获取新的验证码.',
            'integer'  => '请输入合法帐号，应由数字构成',
            'string'   => '请输入符合格式的 :attribute'
        ];
        $validator = Validator::make($request->toArray(), [
            'id'          => 'required',
            'code'        => 'required|integer|exists:verify_codes,code',
            'name'        => 'required|string',
            'account'     => 'required',
            'bank_name'   => 'required|string',
            'bank_branch' => 'required|string',
        ], $messages);
        if ($validator->fails()) {
            return $this->validateErrorResponseInJson($validator);
        }
        $user = User::find($request->id);
        $verifyCode = $user->verifyCodes()->where('code', $request->code)->first();
        $result = $verifyCodes->codeValidate($verifyCode, $request->code, Carbon::now());
        if ($result['Result'] == 'OK') {    //綁定帳號
            $bankCardLimit = 20;
            if ($user->accounts->count() < $bankCardLimit) {
                $user->addAccount(new Account([
                    'name'        => $request->name,
                    'account'     => $request->account,
                    'bank_name'   => $request->bank_name,
                    'bank_branch' => $request->bank_branch
                ]));
                activity($user->email)->causedBy($user)->log('绑订了一笔帐号');

                return $result;
            } else {
                return $this->errorResponse('此商户已绑订' . $bankCardLimit . '组帐号，请删除就有帐号后重试');
            }
        } else {
            return $result;
        }                 //回傳錯誤
    }
}

