<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/12/24
 * Time: 下午 04:31
 */

namespace App\Service;

use App\Http\Requests\AuthCodeOrderSearchRequest;
use App\Repositories\AuthCodes;
use App\Traits\Singleton;
use App\User;

class AuthCodeService
{
    use Singleton;
    /** @var User $user */
    private $user;

    /**
     * @param User $user
     */
    protected function init(User $user)
    {
        $this->user = $user;
    }

    /**
     * 訂單交易資訊
     * @param AuthCodeOrderSearchRequest $request
     * @return \App\Models\Authcode
     */
    public function orderTradeInfo(AuthCodeOrderSearchRequest $request)
    {
        $company = $this->user->getKey();
        // 如果有擁有可選擇商戶的權限
        if ($this->user->hasAccess('users.dataSwitch')) {
            $company = $request->get('company', $company);
        }

        return app(AuthCodes::class)->orderTradeInfo($company, $request->get('start'), $request->get('end'));
    }
}
