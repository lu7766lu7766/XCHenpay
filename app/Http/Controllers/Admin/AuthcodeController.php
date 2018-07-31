<?php

namespace App\Http\Controllers\Admin;

use App\Authcode;
use App\Payment;
use App\Repositories\AuthCodes;
use App\User;
use App\Http\Controllers\Controller;
use function request;
use Sentinel;
use Response;
use Yajra\DataTables\DataTables;

class AuthcodeController extends Controller
{
    public function index(){
        $authCode = Authcode::all();

        $user = Sentinel::getUser();

        $switchPromission = $user->hasAccess('users.dataSwitch');

        if($switchPromission)
            $companies = User::All()->where('company_service_id', '<>', null);

        return view('admin.trade.logQuery', compact('companies', 'switchPromission'));
    }

    public function data(AuthCodes $authCodes)
    {
        $startDate = request()->startDate . ' 00:00:00';
        $endDate = request()->endDate . ' 23:59:59';

        $user = Sentinel::getUser();

        if($user->hasAccess('users.dataSwitch')){
            if(isset(request()->company)){
                $company = User::find(request()->company);

                $authCode = $authCodes->companyData($company->company_service_id, $startDate, $endDate);
            }else{
                $authCode = $authCodes->allData($startDate, $endDate);
            }
        }else{
            $authCode = $authCodes->companyData($user->company_service_id, $startDate, $endDate);
        }

        return $authCodes->makeSimpleDatatable($authCode);
    }

    public function feeData()
    {
        $payments = Payment::where('id', '>', 1)->get();

        return $this->makeFeeDatatable($payments);
    }

    private function makeFeeDatatable($payments)
    {
        return DataTables::of($payments)
            ->editColumn('fee',function($payment){
                return $payment->fee . '%';
            })
            ->addColumn('actions',function($payment) {
                $infoLink = '<a href='. route('admin.authcode.showFeeInfo', ['payment' => $payment->id]) .' data-toggle="modal" data-target="#show_FeeInfo"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="通道讯息"></i></a>';
                $editLink = '<a href='. route('admin.authcode.editFeeInfo', ['payment' => $payment->id]) .' data-toggle="modal" data-target="#edit_FeeInfo"><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="编辑通道"></i></a>';
                $action = $infoLink;

                if(1)
                    $action .= $editLink;

                return $action;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function showFeeInfo(Payment $payment){
        return view('admin.trade.showFeeModal', compact('payment'));
    }

    public function editFeeInfo(Payment $payment){
        return view('admin.trade.editFeeModal', compact('payment'));
    }

    public function updateFeeInfo(){
        $payment = Payment::find(request()->id);

        $payment->update(['fee' => request()->fee]);
//        $payment->save();
    }
}
