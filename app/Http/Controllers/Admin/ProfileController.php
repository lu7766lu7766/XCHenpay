<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiErrorScalarCodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateCodeRequest;
use App\Service\ProfileService;
use App\User;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function indexView()
    {
        return view('admin.users.show');
    }

    /**
     * @return array
     */
    public function info()
    {
        /** @var User $user */
        $user = \Sentinel::getUser();
        $user->load('roles');

        return ['data' => $user];
    }

    /**
     * @param ProfileUpdateCodeRequest $request
     * @return array
     * @throws ApiErrorScalarCodeException
     */
    public function update(ProfileUpdateCodeRequest $request)
    {
        return ['data' => ProfileService::getInstance(\Sentinel::getUser())->updatePassword($request)];
    }
}
