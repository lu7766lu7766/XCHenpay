<?php namespace App\Http\Controllers\Admin;

use App\Service\UserService;
use App\User;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Hash;
use Illuminate\Http\Request;
use Sentinel;

class UsersController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * 新增商戶資訊
     * @return array
     */
    public function dataAdd()
    {
        $service = UserService::getInstance($this->req);
        return $service->userDataAdd();
    }

    /**
     * 取得商戶列表資訊
     * @return User[]|array
     */
    public function data()
    {
        $service = UserService::getInstance($this->req);
        return $service->userData();
    }

    /**
     * 取得商戶列表總筆數
     * @return array
     */
    public function dataTotal()
    {
        $service = UserService::getInstance($this->req);
        return $service->userDataTotal();
    }

    /**
     * 取得商戶列表資訊明細
     * @return User[]|array
     */
    public function dataDetail()
    {
        $service = UserService::getInstance($this->req);
        return $service->userDataDetail();
    }

    /**
     * 更新商戶資訊
     * @return User[]|array
     */
    public function dataUpdate()
    {
        $service = UserService::getInstance($this->req);
        return $service->userDataUpdate();
    }

    /**
     * 刪除商戶
     * @return array
     */
    public function dataDel()
    {
        $service = UserService::getInstance($this->req);
        return $service->userDataDel();
    }

    /**
     * 更新商戶下發狀態
     * @return array
     */
    public function applyStatusUpdate()
    {
        $service = UserService::getInstance($this->req);
        return $service->applyStatusUpdate();
    }

    /**
     * 查詢已刪除帳號列表
     * @return User[]
     */
    public function dataTrashed()
    {
        $service = UserService::getInstance($this->req);
        return $service->userDataTrashed();
    }

    /**
     * 查詢已刪除帳號列表總筆數
     * @return User[]
     */
    public function dataTrashedTotal()
    {
        $service = UserService::getInstance($this->req);
        return $service->userDataTrashedTotal();
    }

    /**
     * 還原已刪除帳號
     * @return array
     */
    public function dataRestore()
    {
        $service = UserService::getInstance($this->req);
        return $service->userDataRestore();
    }

    /**
     * 取得所有角色清單
     * @return array| EloquentRole[]
     */
    public function getRolesList()
    {
        $service = UserService::getInstance($this->req);
        return $service->getRolesList();
    }

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
