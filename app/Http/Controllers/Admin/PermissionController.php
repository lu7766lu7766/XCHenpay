<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;

class PermissionController extends Controller
{
    public function permissionSwitch() {
        $roles = Sentinel::getRoleRepository()->all()->keyBy('id');
        return view('admin.permissions.switch', compact('roles'));
    }

    public function update(Request $request) {
        $user = Sentinel::findRoleById($request->id);
        $user->updatePermission($request->key, filter_var($request->state, FILTER_VALIDATE_BOOLEAN))->save();
        return response()->json($user);
    }
}