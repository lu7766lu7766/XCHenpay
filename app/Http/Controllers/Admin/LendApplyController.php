<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Models\LendRecord;
use App\Repositories\AuthCodes;
use App\Repositories\LendRecords;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;
use Sentinel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Validator;
use Yajra\DataTables\DataTables;

class LendApplyController extends Controller
{
    public function index()
    {
        $companies = User::all()->where('company_service_id', '<>', null);

        // Show the page
        return view('admin.trade.lendApply', compact('companies'));
    }

    public function getLendInfo(AuthCodes $authCodes)
    {
        $user = User::find(request()->id);
        $data = $authCodes->getMoneyRecord($user);
        $data += ['accounts' => $user->accounts->toArray()];

        return $data;
    }

    public function apply(Request $request, AuthCodes $authCodes)
    {
        $messages = [
            'required' => ':attribute 是必填资讯.',
            'exists'   => '此银行卡不存在，请刷新页面后重试.',
            'integer'  => '请输入有效:attribute，应由数字构成',
        ];
        $validator = Validator::make($request->toArray(), [
            'client'  => 'required|exists:users,id',
            'amount'  => 'required|integer',
            'account' => 'required|integer|exists:accounts,id'
        ], $messages);
        if ($validator->fails()) {
            return $this->validateErrorResponseInJson($validator);
        }
        /*
         * 下发金额不可小于及大于设定值
         */
        if ($request->amount < config('constants.apply.min') || $request->amount > config('constants.apply.max')) {
            return Response::json([
                'Result'  => 'error',
                'Message' => '下发金额填写错误, 请重新输入'
            ]);
        }
        $client = User::find($request->client);
        $account = Account::find($request->account);
        if ($client->apply_status != 'on') {
            return Response::json([
                'Result'  => 'error',
                'Message' => '您无下发申请之权限，请联络客服人员'
            ]);
        }
        if ($account->user_id != $client->id) {
            return Response::json([
                'Result'  => 'error',
                'Message' => '此银行卡持有厂商与要求不符，请联络客服人员'
            ]);
        }
        $data = $authCodes->getMoneyRecord($client);
        $fee = $request->amount * $client->lend_fee;
        $applyAmount = $request->amount + $fee;
        if ($applyAmount > filter_var($data['totalIncome'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)) {
            return Response::json([
                'Result'  => 'error',
                'Message' => '申请金额超过可下发馀额，请联络客服人员'
            ]);
        }
        $client->addLendRecord(new LendRecord([
            'record_seq'   => $seq = Carbon::now('Asia/Taipei')->format('YmdHis'),
            'account_id'   => $request->account,
            'amount'       => $applyAmount,
            'fee'          => $request->amount * $client->lend_fee,
            'lend_state'   => LendRecords::APPLY_STATE,
            'lend_summary' => LendRecords::APPLY_SUMMARY,
            'description'  => (isset($request->description)) ? $request->description : ""
        ]));
        $user = Sentinel::getUser();
        activity($user->email)
            ->causedBy($user)
            ->log('提交一笔下发申请，单号：' . $seq);

        return ['Result' => 'OK'];
    }

    /**
     * 取得下發列表
     * @param LendRecords $lendRecords
     * @return JsonResponse
     * @throws \Exception
     */
    public function data(LendRecords $lendRecords)
    {
        if (isset(request()->companyId)) {
            $lendRecords = $lendRecords->getUserRecords(request()->companyId, request()->startDate, request()->endDate);
        } else {
            $lendRecords = [];
        }

        return $this->makeDataTable($lendRecords);
    }

    /**
     * @param $lendRecords
     * @return JsonResponse
     * @throws \Exception
     */
    private function makeDataTable($lendRecords)
    {
        return DataTables::of($lendRecords)
            ->addColumn('account_name', function ($lendRecord) {
                return $lendRecord->account->name;
            })
            ->addColumn('account', function ($lendRecord) {
                return $lendRecord->account->account;
            })
            ->addColumn('tatol_amount', function ($lendRecord) {
                return $lendRecord->amount - $lendRecord->fee;
            })
            ->addColumn('bank_card_status', function ($lendRecord) {
                $result = '<span style="color: green">正常</span>';
                if (!is_null($lendRecord->account->deleted_at)) {
                    $result = '<span style="color: red">删除</span>';
                }

                return $result;
            })
            ->addColumn('actions', function ($lendRecord) {
                $infoLink = '<a href=' . route('admin.lendApply.showRecord',
                        ['lendRecord' => $lendRecord->id]) . ' data-toggle="modal" data-target="#lend_info"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('Trade/LendManage/form.manage') . '></i></a>';

                return $infoLink;
            })
            ->rawColumns(['actions', 'bank_card_status'])
            ->make(true);
    }

    /**
     * 下發資訊
     * @param LendRecord $lendRecord
     * @return \Illuminate\View\View
     */
    public function showRecordDialog(LendRecord $lendRecord)
    {
        $account = $lendRecord->account()->withTrashed()->first();

        return view('admin.trade.showRecordModal', compact('lendRecord', 'account'));
    }
}
