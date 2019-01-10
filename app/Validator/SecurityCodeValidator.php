<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/1/9
 * Time: 下午 04:07
 */

namespace App\Validator;

use App\User;
use Hash;

class SecurityCodeValidator
{
    /** @var User $user */
    private $user;
    private $code;
    private $success = true;

    /**
     * SecurityCodeValidator constructor.
     * @param User $user
     * @param string $code
     */
    public function __construct(User $user, string $code)
    {
        $this->user = $user;
        $this->setSecurityCode($code);
    }

    /**
     * @param string $code
     */
    public function setSecurityCode(string $code)
    {
        $this->code = $code;
        $this->check();
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        $this->check();
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    private function check()
    {
        if (!Hash::check($this->code, $this->user->secret_code)) {
            $this->success = false;
        }
    }
}
