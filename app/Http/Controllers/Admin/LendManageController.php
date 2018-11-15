<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LendRecord;
use App\Repositories\AuthCodes;
use App\Repositories\LendRecords;
use App\User;
use Illuminate\Http\Request;
use Response;
use Sentinel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Validator;
use Yajra\DataTables\DataTables;

class LendManageController extends Controller
{
    const ALLCOMPANIES = -1;

    public function index()
    {
        $companies = User::all()->where('company_service_id', '<>', null);

        // Show the page
        return view('admin.trade.lendManage', compact('companies'));
    }

    /**
     * @param LendRecords $lendRecords
     * @return JsonResponse
     * @throws \Exception
     */
    public function data(LendRecords $lendRecords)
    {
        $records = collect();
        if (!isset(request()->companyId)) {
            return $this->makeDataTable($records);
        }
        if (request()->companyId == $this::ALLCOMPANIES) {
            $records = $lendRecords->getAllRecords(request()->startDate, request()->endDate);
        } else {
            $records = $lendRecords->getUserRecords(request()->companyId, request()->startDate, request()->endDate);
        }

        return $this->makeDataTable($records);
    }

    /**
     * 計算總和
     * @param LendRecords $lendRecords
     * @return LendRecords|\Illuminate\Database\Eloquent\Model|null
     */
    public function total(LendRecords $lendRecords)
    {
        $userId = null;
        if (request()->userId != self::ALLCOMPANIES) {
            $userId = request()->userId;
        }

        return $lendRecords->getTotal(request()->startDate, request()->endDate, $userId);
    }

    /**
     * 申請中金额,可提現金額
     * @param AuthCodes $authCodes
     * @return array
     */
    public function getApplyingAndWithdrawalAmount(AuthCodes $authCodes)
    {
        $userId = null;
        if (request()->userId != self::ALLCOMPANIES) {
            $userId = request()->userId;
        }
        $result = $this->calculateApplyingAndWithdrawal($authCodes->applyingAndWithdrawalAmount($userId));

        return $result;
    }

    /**
     * @param $lendRecords
     * @return JsonResponse
     * @throws \Exception
     */
    private function makeDataTable($lendRecords)
    {
        return DataTables::of($lendRecords)
            ->addColumn('company_name', function ($lendRecord) {
                return $lendRecord->user->company_name;
            })
            ->addColumn('account_name', function ($lendRecord) {
                return $lendRecord->account->name;
            })
            ->addColumn('account', function ($lendRecord) {
                return $lendRecord->account->account;
            })
            ->addColumn('tatol_amount', function ($lendRecord) {
                return $lendRecord->amount - $lendRecord->fee;
            })->addColumn('bank_card_status', function ($lendRecord) {
                $result = '<span style="color: green">正常</span>';
                if (!is_null($lendRecord->account->deleted_at)) {
                    $result = '<span style="color: red">删除</span>';
                }

                return $result;
            })
            ->addColumn('actions', function ($lendRecord) {
                $lendLink = '<a href=' . route('admin.lendManage.manageRecord',
                        ['lendRecord' => $lendRecord->id]) . ' data-toggle="modal" data-target="#lend_manage"><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title=' . trans('Trade/LendManage/form.manage') . '></i></a>';
                $infoLink = '<a href=' . route('admin.lendManage.showRecord',
                        ['lendRecord' => $lendRecord->id]) . ' data-toggle="modal" data-target="#lend_info"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('Trade/LendManage/form.manage') . '></i></a>';
                $action = $infoLink;
                $action .= $lendLink;

                return $action;
            })
            ->rawColumns(['actions', 'bank_card_status'])
            ->make(true);
    }

    /**
     * @param LendRecord $lendRecord
     * @return \Illuminate\View\View
     */
    public function showRecordDialog(LendRecord $lendRecord)
    {
        $account = $lendRecord->account()->withTrashed()->first();

        return view('admin.trade.showRecordModal', compact('lendRecord', 'account'));
    }

    public function showManageDialog(LendRecord $lendRecord)
    {
        return view('admin.trade.manageRecordModal', compact('lendRecord'));
    }

    public function update(Request $request)
    {
        $messages = [
            'required' => ':attribute 不得为空.',
            'exists'   => '此不存在，请刷新页面后重试.',
        ];
        $validator = Validator::make($request->toArray(), [
            'id'        => 'required|exists:lend_records,id',
            'operation' => 'required|in:0,1',
        ], $messages);
        if ($validator->fails()) {
            return $this->validateErrorResponseInJson($validator);
        }
        $record = LendRecord::find($request->id);
        $user = Sentinel::getUser();
        if ($request->operation) {
            $record->update(['lend_state' => LendRecords::ACCEPT_STATE, 'lend_summary' => LendRecords::ACCEPT_SUMMARY]);
            activity($user->email)
                ->causedBy($user)
                ->log('准許一笔下发申请 ' . $record->record_seq);
        } else {
            $record->update(['lend_state' => LendRecords::DENY_STATE, 'lend_summary' => LendRecords::DENY_SUMMARY]);
            activity($user->email)
                ->causedBy($user)
                ->log('拒绝一笔下发申请 ' . $record->record_seq);
        }

        return Response::json([
            'Result' => 'OK'
        ]);
    }

    /**
     * 計算申請中金额,可提現金額
     * @param array $data
     * @return array
     */
    private function calculateApplyingAndWithdrawal(array $data)
    {
        $totalMoney = 0;
        $totalFee = 0;
        $totalApplying = 0;
        $withdrawal = 0;
        foreach ($data as $dataInfo) {
            $totalMoney += current($dataInfo['trade_logs'])['totalMoney'] ?? 0;
            $totalFee += current($dataInfo['trade_logs'])['totalFee'] ?? 0;
            foreach ($dataInfo['lend_records'] as $lendsInfo) {
                switch ($lendsInfo['lend_state']) {
                    case 0:
                        $totalApplying += round($lendsInfo['totalMoney'], 3);
                        break;
                    case 1:
                        $withdrawal += round($lendsInfo['totalMoney'], 3);
                        break;
                }
            }
        }
        $result = [
            'totalApplying'   => number_format($totalApplying, 3, ".", ","),
            'totalWithdrawal' => number_format($totalMoney - $totalFee - $totalApplying - $withdrawal, 3, ".", ",")
        ];

        return $result;
    }
}
