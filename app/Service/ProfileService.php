<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/3
 * Time: 下午 06:09
 */

namespace App\Service;

use App\Constants\ErrorCode\Article\OOO2ProfileErrorCodes;
use App\Exceptions\ApiErrorScalarCodeException;
use App\Http\Requests\ProfileUpdateCodeRequest;
use App\Repositories\ActivityRepository;
use App\Repositories\UserRepo;
use App\Traits\Singleton;
use App\User;
use Hash;
use XC\Independent\Kit\Support\Scalar\ArrayMaster;

class ProfileService
{
    use Singleton;
    /** @var User $user */
    private $user;

    /**
     * @param User $user
     */
    public function init(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param ProfileUpdateCodeRequest $request
     * @return bool
     * @throws ApiErrorScalarCodeException
     */
    public function updatePassword(ProfileUpdateCodeRequest $request)
    {
        $result = false;
        $data = [];
        $logMsg = '';
        if (!is_null($request->getSecretCode())) {
            $userSecretCode = $this->user->secret_code;
            if (is_null($userSecretCode) || Hash::check($request->getOldSecretCode(), $userSecretCode)) {
                $data['secret_code'] = Hash::make($request->getSecretCode());
                $logMsg = '修改了安全碼';
            } else {
                throw  new  ApiErrorScalarCodeException('輸入錯誤安全碼', OOO2ProfileErrorCodes::TYPE_WRONG_SECRET_CODE);
            }
        }
        if (!is_null($request->getPassword())) {
            $password = $this->user->password;
            if (Hash::check($request->getOldPassword(), $password)) {
                $data['password'] = Hash::make($request->getPassword());
                $logMsg .= !is_null($request->getSecretCode()) ? '和密碼' : '修改了密碼';
            } else {
                throw  new  ApiErrorScalarCodeException('輸入錯誤密碼', OOO2ProfileErrorCodes::TYPE_WRONG_PASSWORD);
            }
        }
        if (ArrayMaster::isList($data)) {
            try {
                \DB::transaction(function () use ($data, $logMsg, &$result) {
                    $result = app(UserRepo::class)->update($this->user, $data);
                    if ($result) {
                        app(ActivityRepository::class)->addActivityLog($this->user->email, $this->user, $logMsg);
                    }
                });
            } catch (\Throwable $e) {
                \Log::error('file:' . $e->getFile() . 'line:' . $e->getLine() . 'message:' . $e->getMessage());
            }
        }

        return $result;
    }
}
