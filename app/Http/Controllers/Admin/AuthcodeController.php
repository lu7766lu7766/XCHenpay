<?php

namespace App\Http\Controllers\Admin;

use App\Authcode;
use function compact;
use App\Http\Controllers\Controller;

class AuthcodeController extends Controller
{
    public function index(){
        $authCodes = Authcode::all();

        return view('admin.authcode.index', compact('authCodes'));
    }
}
