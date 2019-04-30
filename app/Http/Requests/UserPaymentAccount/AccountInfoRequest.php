<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/4/25
 * Time: 下午 07:15
 */

namespace App\Http\Requests\UserPaymentAccount;

use App\Constants\PaymentManage\PaymentManageVendorsCodeConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountInfoRequest extends FormRequest
{
    /**
     * @return array
     */
    public function getVendors()
    {
        return $this->get('vendors', []);
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'vendors'   => 'sometimes|required|array',
            'vendors.*' => 'sometimes|required|' . Rule::in(PaymentManageVendorsCodeConstants::enum()),
        ];
    }
}
