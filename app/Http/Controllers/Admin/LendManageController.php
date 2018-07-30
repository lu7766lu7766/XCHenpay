<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\LendRecords;
use Yajra\DataTables\DataTables;
use App\Repositories\AuthCodes;
use Illuminate\Http\Request;
use App\LendRecord;
use App\Authcode;
use Validator;
use App\User;
use Sentinel;
use Response;

class LendManageController extends Controller
{
    public function index()
    {
        $companies = User::all()->where('company_service_id', '<>', null);

        // Show the page
        return view('admin.trade.lendManage', compact('companies'));
    }

    public function getLendInfo(AuthCodes $authCodes)
    {
        $user = User::find(request()->id);

        $data = $authCodes->getMoneyRecord($user);

        $data += ['accounts' => $user->accounts->toArray()];

        return $data;
    }

    public function data(LendRecords $lendRecords)
    {
        if(isset(request()->companyId)) {
            $user = User::find(request()->companyId);

            $lendRecords = $lendRecords->getUserRecords($user, request()->startDate, request()->endDate);
        }else{
            $lendRecords = [];
        }
//        dd($lendRecords);
        return $this->makeDataTable($lendRecords);
    }

    private function makeDataTable($lendRecords)
    {
        return DataTables::of($lendRecords)
            ->addColumn('account_name',function($lendRecord){
                return $lendRecord->account->name;
            })
            ->addColumn('account',function($lendRecord){
                return $lendRecord->account->account;
            })
            ->addColumn('tatol_amount',function($lendRecord){
                return $lendRecord->amount - $lendRecord->fee;
            })
            ->addColumn('actions',function($lendRecord){
                $lendLink = '<a href='. route('admin.lendManage.manageRecord', ['lendRecord' => $lendRecord->id]) .' data-toggle="modal" data-target="#lend_manage"><i class="livicon" data-name="rocket" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title=' . trans('Trade/LendManage/form.manage') . '></i></a>';
                $infoLink = '<a href='. route('admin.lendManage.showRecord', ['lendRecord' => $lendRecord->id]) .' data-toggle="modal" data-target="#lend_info"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('Trade/LendManage/form.manage') . '></i></a>';

                $action = '';

                if($lendRecord->lend_state == LendRecords::APPLY_STATE){
                    $action .= $lendLink;
                    $action .= $infoLink;
                }
                else
                    $action .= $infoLink;

                return $action;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function showRecordDialog(LendRecord $lendRecord){
        $account = $lendRecord->account;

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

        $validator = Validator::make( $request->toArray(), [
            'id' => 'required|exists:lend_records,id',
            'operation' => 'required|in:0,1',
        ],$messages);

        if ($validator->fails())
            return $this->validateErrorResponseInJson($validator);

        $record = LendRecord::find($request->id);

        //訂單下申請狀態不能作管理
        if($record->lend_state != LendRecords::APPLY_STATE){
            return Response::json(array(
                'Result' => 'error',
                'Message'=> '此单非申请下发状态，请重新整理后再次尝试'
            ));
        }

        $user = Sentinel::getUser();

        if($request->operation){
            $record->update(['lend_state' => LendRecords::ACCEPT_STATE, 'lend_summary' => LendRecords::ACCEPT_SUMMARY]);

            activity($user->email)
                ->causedBy($user)
                ->log('准許一笔下发申请 ' . $record->record_seq);
        }
        else{
            $record->update(['lend_state' => LendRecords::DENY_STATE, 'lend_summary' => LendRecords::DENY_SUMMARY]);

            activity($user->email)
                ->causedBy($user)
                ->log('拒绝一笔下发申请 ' . $record->record_seq);
        }

        return Response::json(array(
            'Result' => 'OK'
        ));
    }
}
