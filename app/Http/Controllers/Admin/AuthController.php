<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\UserRequest;
use App\Mail\ForgotPassword;
use App\Traits\WhitelistValidation;
use App\User;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Mail;
use Reminder;
use Sentinel;
use stdClass;
use URL;
use View;

class AuthController extends JoshController
{
    use WhitelistValidation;

    /**
     * @return Factory|RedirectResponse
     */
    public function getSignin()
    {
        // Is the user logged in?
        if (Sentinel::check()) {
            return Redirect::route('admin.authcode.index');
        }

        // Show the page
        return view('admin.login');
    }

    public function signIn(Request $request)
    {
        try {
            $userConfig = $request->only(['email', 'password']);
            $isRememberMe = $request->get('remember-me', false);
            /** @var User|bool $user */
            if (($user = Sentinel::authenticate($userConfig, $isRememberMe)) && $user->status == 'on') {
                if ($this->isAllowIp($user, $request->getClientIp())) {
                    //Activity log
                    activity($user->email)
                        ->performedOn($user)
                        ->causedBy($user)
                        ->log('登入');
                    $redirect = Redirect::route("admin.authcode.index")
                        ->with('success', trans('auth/message.signin.success'));
                } else {
                    Sentinel::logout($user);
                    $redirect = redirect(route('login'))->withInput()
                        ->with('error', 'Not Allowed from Ip Address:' . $request->getClientIp());
                }
            } else {
                $redirect = Redirect::back()->withInput()->with('error', trans('auth/message.account_not_found'));
            }
        } catch (NotActivatedException $e) {
            $message = trans('auth/message.account_not_activated');
            $redirect = Redirect::back()->withInput()->with('error', $message);
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            $message = trans('auth/message.account_suspended', compact('delay'));
            $redirect = Redirect::back()->withInput()->with('error', $message);
        }

        return $redirect;
    }

    /**
     * Account sign up form processing.
     *
     * @return Redirect
     */
    public function postSignup(UserRequest $request)
    {
        try {
            // Register the user
            $user = Sentinel::registerAndActivate([
                'email'    => $request->get('email'),
                'password' => $request->get('password'),
            ]);
            //add user to 'User' group
            $role = Sentinel::findRoleById(2);
            $role->users()->attach($user);
            // Log the user in
            $name = Sentinel::login($user, false);
            //Activity log
            activity($name->email)
                ->performedOn($user)
                ->causedBy($user)
                ->log('Registered');
            //activity log ends
            // Redirect to the home page with success menu
            return Redirect::route("admin.dashboard")->with('success', trans('auth/message.signup.success'));
        } catch (UserNoException $e) {
            //
        }

        // Ooops.. something went wrong
        return Redirect::back()->with('warning', trans('auth/message.account_already_exists'));
    }

    /**
     * User account activation page.
     *
     * @param number $userId
     * @param string $activationCode
     * @return
     */
    public function getActivate($userId, $activationCode = null)
    {
        // Is user logged in?
        if (Sentinel::check()) {
            return Redirect::route('admin.dashboard');
        }
        $user = Sentinel::findById($userId);
        $activation = Activation::create($user);
        if (Activation::complete($user, $activation->code)) {
            // Activation was successful
            // Redirect to the login page
            return Redirect::route('signin')->with('success', trans('auth/message.activate.success'));
        } else {
            // Activation not found or not completed.
            return Redirect::route('signin')->with('error', trans('auth/message.activate.error'));
        }
    }

    /**
     * Forgot password form processing page.
     * @param Request $request
     *
     * @return Redirect
     */
    public function postForgotPassword(ForgotRequest $request)
    {
        $data = new stdClass();
        try {
            // Get the user password recovery code
            $user = Sentinel::findByCredentials(['email' => $request->get('email')]);
            if (!$user) {
                return back()->with('error', trans('auth/message.account_email_not_found'));
            }
            $activation = Activation::completed($user);
            if (!$activation) {
                return back()->with('error', trans('auth/message.account_not_activated'));
            }
            $reminder = Reminder::exists($user) ?: Reminder::create($user);
            // Data to be used on the email view
            $data->forgotPasswordUrl = URL::route('forgot-password-confirm', [$user->id, $reminder->code]);
            // Send the activation code through email
            Mail::to($user->email)
                ->send(new ForgotPassword($data));
        } catch (UserNotFoundException $e) {
            // Even though the email was not found, we will pretend
            // we have sent the password reset code through email,
            // this is a security measure against hackers.
        }

        //  Redirect to the forgot password
        return back()->with('success', trans('auth/message.forgot-password.success'));
    }

    /**
     * Forgot Password Confirmation page.
     *
     * @param number $userId
     * @param  string $passwordResetCode
     * @return View
     */
    public function getForgotPasswordConfirm($userId, $passwordResetCode = null)
    {
        // Find the user using the password reset code
        if (!$user = Sentinel::findById($userId)) {
            // Redirect to the forgot password page
            return Redirect::route('forgot-password')->with('error', trans('auth/message.account_not_found'));
        }
        if ($reminder = Reminder::exists($user)) {
            if ($passwordResetCode == $reminder->code) {
                return view('admin.auth.forgot-password-confirm');
            } else {
                return 'code does not match';
            }
        } else {
            return 'does not exists';
        }
        // Show the page
        // return View('admin.auth.forgot-password-confirm');
    }

    /**
     * Forgot Password Confirmation form processing page.
     *
     * @param Request $request
     * @param number $userId
     * @param  string $passwordResetCode
     * @return Redirect
     */
    public function postForgotPasswordConfirm(ConfirmPasswordRequest $request, $userId, $passwordResetCode = null)
    {
        // Find the user using the password reset code
        $user = Sentinel::findById($userId);
        if (!$reminder = Reminder::complete($user, $passwordResetCode, $request->get('password'))) {
            // Ooops.. something went wrong
            return Redirect::route('signin')->with('error', trans('auth/message.forgot-password-confirm.error'));
        }

        // Password successfully reseted
        return Redirect::route('signin')->with('success', trans('auth/message.forgot-password-confirm.success'));
    }

    /**
     * Logout page.
     *
     * @return Redirect
     */
    public function getLogout()
    {
        if (Sentinel::check()) {
            //Activity log
            $user = Sentinel::getuser();
            activity($user->email)
                ->performedOn($user)
                ->causedBy($user)
                ->log('登出');
            // Log the user out
            Sentinel::logout();
        }

        // Redirect to the users page
        return redirect('admin/signin')->with('success', '您已成功登出');
    }

    /**
     * Account sign up form processing for register2 page
     *
     * @param Request $request
     *
     * @return Redirect
     */
    public function postRegister2(UserRequest $request)
    {
        try {
            // Register the user
            $user = Sentinel::registerAndActivate([
                'email'    => $request->get('email'),
                'password' => $request->get('password'),
            ]);
            //add user to 'User' group
            $role = Sentinel::findRoleById(2);
            $role->users()->attach($user);
            // Log the user in
            Sentinel::login($user, false);

            // Redirect to the home page with success menu
            return Redirect::route("admin.dashboard")->with('success', trans('auth/message.signup.success'));
        } catch (UserExistsException $e) {
            //
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors('warning', trans('auth/message.account_already_exists'));
    }
}
