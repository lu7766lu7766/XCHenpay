<?php namespace App\Http\Controllers\Admin;

use App\account;
use App\Authcode;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use App\Http\Controllers\JoshController;
use Google_Service_Compute_NetworkInterface;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UserRequest;
use App\Repositories\VerifyCodes;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
Use App\Mail\Activate;
Use Curl\Curl;
use App\User;
use Response;
use Validator;
use Redirect;
use Sentinel;
use stdClass;
use File;
use Hash;
use View;
use URL;

class UsersController extends JoshController
{

    /**
     * Show a list of all the users.
     *
     * @return View
     */

    public function index()
    {

        // Show the page
        return view('admin.users.index');
    }

    /*
     * Pass data through ajax call
     */
    /**
     * @return mixed
     */
    public function data()
    {
        $users = User::get(['id', 'company_name', 'email', 'QQ_id','created_at']);

        return DataTables::of($users)
            ->addColumn('actions',function($user) {
                $showLink = '<a href='. route('admin.users.show', $user->id) .'><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('users/UserList/form.view user') . '></i></a>';
                $showSelfLink = '<a href='. route('admin.users.showProfile') .'><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('users/UserList/form.view user') . '></i></a>';
                $editLink = '<a href='. route('admin.users.edit', $user->id) .'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('users/UserList/form.update user') . '></i></a>';
                $editSelfLink = '<a href='. route('admin.users.editProfile') .'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('users/UserList/form.update user') . '></i></a>';
                $deleteLink = '<a href='. route('admin.users.confirm-delete', $user->id) .' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="user-remove" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title=' . trans('users/UserList/form.delete user') . '></i></a>';

                $actions = '';
                if(Sentinel::getUser()->id != $user->id)
                    $actions .= $showLink;
                else
                    $actions .= $showSelfLink;

                if(Sentinel::getUser()->id != $user->id)
                    $actions .= $editLink;
                else
                    $actions .= $editSelfLink;


                if (Sentinel::inRole('admin') && Sentinel::getUser()->id != $user->id)           //check if user is admin
                    $actions .= $deleteLink;

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Create new user
     *
     * @return View
     */
    public function create()
    {
        // Get all the available groups
        $groups = Sentinel::getRoleRepository()->all();

        // Show the page
        return view('admin.users.create', compact('groups'));
    }

    /**
     * User create form processing.
     *
     * @return Redirect
     */
    public function store(UserRequest $request)
    {

        try {
            $activate = true;

            $data = $request->except('_token', 'group', 'activate');
            $data['password'] = strtolower(str_random(8));
            $data['company_service_id'] = md5(str_random(32));
            $data['sceret_key'] = md5(str_random(32));
            //dd($request->toArray());

            // Register the user
            $user = Sentinel::register($data, $activate);

            //add user to 'User' group
            $role = Sentinel::findRoleById($request->get('group'));
            if ($role) {
                $role->users()->attach($user);
            }

            //check for activation and send activation mail if not activated by default
            if ($activate) {
                $mail = new stdClass();

                // Data to be used on the email view
                $mail->username = $user->email;
                $mail->password = $data['password'];
                $mail->activationUrl = URL::route('signin');

                // Send the activation code through email
                Mail::to($user->email)
                    ->send(new Activate($mail));
            }
            // Activity log for New user create
            activity($user->email)
                ->performedOn($user)
                ->causedBy($user)
                ->log('New User Created by '.Sentinel::getUser()->email);
            // Redirect to the home page with success menu
            return Redirect::route('admin.users.index')->with('success', trans('users/message.success.create'));

        } catch (LoginRequiredException $e) {
            $error = trans('admin/users/message.user_login_required');
        } catch (PasswordRequiredException $e) {
            $error = trans('admin/users/message.user_password_required');
        } catch (UserExistsException $e) {
            $error = trans('admin/users/message.user_exists');
        }

        // Redirect to the user creation page
        return Redirect::back()->withInput()->with('error', $error);
    }

    /**
     * User update.
     *
     * @param  int $id
     * @return View
     */
    public function edit(User $user)
    {
        // Get this user groups
        $userRoles = $user->getRoles()->pluck('name', 'id')->all();
        // Get a list of all the available groups
        $roles = Sentinel::getRoleRepository()->all();

        $status = Activation::completed($user);

        //$countries = $this->countries;

        // Show the page
        return view('admin.users.edit', compact('user', 'roles', 'userRoles', 'countries', 'status'));
    }

    public function editProfile()
    {
        $user = Sentinel::getUser();

        return $this->edit($user);
    }

    /**
     * User update form processing page.
     *
     * @param  User $user
     * @param UserRequest $request
     * @return Redirect
     */
    public function update(User $user, UserRequest $request)
    {
        $data = new stdClass();

        try {
//            dd($request->toArray());

            $user->update($request->except('password','password_confirm','groups','activate'));

            if ( !empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            // Get the current user groups
            $userRoles = $user->roles()->pluck('id')->all();

            // Get the selected groups
            $selectedRoles = $request->get('groups');

            // Groups comparison between the groups the user currently
            // have and the groups the user wish to have.
            $rolesToAdd = array_diff($selectedRoles, $userRoles);
            $rolesToRemove = array_diff($userRoles, $selectedRoles);

            // Assign the user to groups

            foreach ($rolesToAdd as $roleId) {
                $role = Sentinel::findRoleById($roleId);
                $role->users()->attach($user);
            }

            // Remove the user from groups
            foreach ($rolesToRemove as $roleId) {
                $role = Sentinel::findRoleById($roleId);
                $role->users()->detach($user);
            }

            // Was the user updated?
            if ($user->save()) {
                // Prepare the success message
                $success = trans('users/message.success.update');
               //Activity log for user update
                activity($user->email)
                    ->performedOn($user)
                    ->causedBy($user)
                    ->log('更新了联络信息');
                // Redirect to the user page
                return Redirect::route('admin.users.edit', $user)->with('success', $success);
            }

            // Prepare the error message
            $error = trans('users/message.error.update');
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('error', $error);
        }

        // Redirect to the user page
        return Redirect::route('admin.users.edit', $user)->withInput()->with('error', $error);
    }

    public function updateProfile(UserRequest $request)
    {
        $user = Sentinel::getUser();
        return $this->update($user, $request);
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
     * Delete Confirm
     *
     * @param   int $id
     * @return  View
     */
    public function getModalDelete($id)
    {
        $model = 'users';
        $confirm_route = $error = null;
        try {
            // Get user information
            $user = Sentinel::findById($id);

            // Check if we are not trying to delete ourselves
            if ($user->id === Sentinel::getUser()->id) {
                // Prepare the error message
                $error = trans('users/message.error.delete');

                return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('users/message.user_not_found', compact('id'));
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
        $confirm_route = route('admin.users.delete', ['id' => $user->id]);
        return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    /**
     * Delete the given user.
     *
     * @param  int $id
     * @return Redirect
     */
    public function destroy($id)
    {
        try {
            // Get user information
            $user = Sentinel::findById($id);
            // Check if we are not trying to delete ourselves
            if ($user->id === Sentinel::getUser()->id) {
                // Prepare the error message
                $error = trans('admin/users/message.error.delete');
                // Redirect to the user management page
                return Redirect::route('admin.users.index')->with('error', $error);
            }
            // Delete the user
            //to allow soft deleted, we are performing query on users model instead of Sentinel model
            User::destroy($id);
            Activation::where('user_id',$user->id)->delete();
            // Prepare the success message
            $success = trans('users/message.success.delete');
            //Activity log for user delete
            activity($user->email)
                ->performedOn($user)
                ->causedBy($user)
                ->log('User deleted by '.Sentinel::getUser()->email);
            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('success', $success);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('error', $error);
        }
    }

    /**
     * Restore a deleted user.
     *
     * @param  int $id
     * @return Redirect
     */
    public function getRestore($id)
    {
        $data = new stdClass();
        try {
            // Get user information
            $user = User::withTrashed()->find($id);
            info($user);
            // Restore the user
            $user->restore();
            // create activation record for user and send mail with activation link
            $data->activationUrl = URL::route('activate', [$user->id, Activation::create($user)->code]);

            //todo Send the activation code through email
//            Mail::to($user->email)
//                ->send(new Restore($data));

            // Prepare the success message
            $success = trans('users/message.success.restored');
            activity($user->email)
                ->performedOn($user)
                ->causedBy($user)
                ->log('User restored by '.Sentinel::getUser()->email);
            // Redirect to the user management page
            return Redirect::route('admin.deleted_users')->with('success', $success);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('admin.deleted_users')->with('error', $error);
        }
    }

    /**
     * Display specified user profile.
     *
     * @param  int $id
     * @return Response
     */
    public function show(User $user)
    {
        try {
            //get country name
            if ($user->country) {
                $user->country = $this->countries[$user->country];
            }
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('users/message.user_not_found', compact('id'));
            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('error', $error);
        }
        // Show the page
        return view('admin.users.show', compact('user'));
    }

    public function showProfile()
    {
        $user = Sentinel::getUser();

        return $this->show($user);
    }

    public function passwordreset(Request $request)
    {
        $id = $request->id;
        $user = Sentinel::findUserById($id);
        $password = $request->get('password');
        $user->password = Hash::make($password);
        $user->save();

        activity($user->email)
            ->performedOn($user)
            ->causedBy($user)
            ->log('修改了密码');
    }

    public function lockscreen($id){

        if (Sentinel::check()) {
            $user = Sentinel::findUserById($id);
            return view('admin.lockscreen',compact('user'));
        }
        return view('admin.login');
    }

    public function postLockscreen(Request $request){
        $password = Sentinel::getUser()->password;
        if(Hash::check($request->password,$password)){
            return 'success';
        } else{
            return 'error';
        }
    }

}
