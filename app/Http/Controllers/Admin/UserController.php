<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
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
}
