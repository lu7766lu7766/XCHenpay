<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LendRecord;
use App\Repositories\AuthCodes;
use App\Repositories\LendRecords;
use Yajra\DataTables\DataTables;
use Validator;
use Response;
use Sentinel;

class LendingController extends Controller
{
    public function index()
    {
        return view('admin.trade.showLending');
    }

    public function getInfo(AuthCodes $authCodes)
    {
        $user = Sentinel::getUser();

        $data = $authCodes->getMoneyRecord($user);

        return $data;
    }

    public function data(LendRecords $lendRecords)
    {
        $user = Sentinel::getUser();

        $lendRecords = $lendRecords->getUserRecords($user, request()->startDate, request()->endDate);

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
                $infoLink = '<a href='. route('admin.showLending.showRecord', ['lendRecord' => $lendRecord->id]) .' data-toggle="modal" data-target="#lend_info"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('Trade/LendManage/form.manage') . '></i></a>';

                return $infoLink;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function showRecordDialog(LendRecord $lendRecord){
        $account = $lendRecord->account;

        return view('admin.trade.showRecordModal', compact('lendRecord', 'account'));
    }


}
