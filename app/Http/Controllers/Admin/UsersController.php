<?php namespace App\Http\Controllers\Admin;

use App\User;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Hash;
use Illuminate\Http\Request;
use Sentinel;

class UsersController extends BaseController
{
    /**
     * 取得所有角色資訊
     * @return array| EloquentRole[]
     */
    public function getThisUser()
    {
        return Sentinel::getUser();
    }

    /**
     * Show a list of all the deleted users.
     *
     * @return View
     */
    public function getDeletedUsers()
    {
        // Grab deleted users
        $users = User::onlyTrashed()->get();

        // Show the page
        return view('admin.users.deleted_users', compact('users'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function showProfile()
    {
        /**@var User $user */
        $user = Sentinel::getUser();

        return view('admin.users.show', compact('user'));
    }

    public function passwordreset(Request $request)
    {
        $id = $request->id;
        $user = Sentinel::findUserById($id);
        $password = $request->get('password');
        if (!Sentinel::validateCredentials($user, ['password' => $request->get('oldPassword')])) {
            return $this->errorResponse('修正失败，旧密码不正确');
        }
        $user->password = Hash::make($password);
        $user->save();
        activity($user->email)
            ->performedOn($user)
            ->causedBy($user)
            ->log('修改了密碼');

        return $this->okayResponse();
    }

    public function lockscreen($id)
    {
        if (Sentinel::check()) {
            $user = Sentinel::findUserById($id);

            return view('admin.users.lockscreen', compact('user'));
        }

        return view('admin.login');
    }

    public function postLockscreen(Request $request)
    {
        $password = Sentinel::getUser()->password;
        if (Hash::check($request->password, $password)) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function getUserInfo(Request $request)
    {
        $id = $request->id;
        $user = Sentinel::findUserById($id);

        return $user;
    }
}
