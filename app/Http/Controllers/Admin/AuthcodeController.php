<?php

namespace App\Http\Controllers\Admin;

use App\Authcode;
use App\Repositories\AuthCodes;
use App\User;
use App\Http\Controllers\Controller;
use Sentinel;

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
}
