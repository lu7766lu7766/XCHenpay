<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/2/11
 * Time: 下午 02:31
 */

namespace App\Http\Requests\SystemSetting;

use App\Constants\PaymentManage\PaymentManageDepositTypeConstants;
use App\Constants\PaymentManage\PaymentManageStatusConstants;
use App\Constants\PaymentManage\PaymentManageVendorsCodeConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentManageUpdateRequest extends FormRequest
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->get('id');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->get('status', PaymentManageStatusConstants::ON);
    }

    /**
     * @return int
     */
    public function getMinDeposit()
    {
        return $this->get('min_deposit');
    }

    /**
     * @return int
     */
    public function getMaxDeposit()
    {
        return intval($this->get('max_deposit'));
    }

    /**
     * @return int
     */
    public function getTotalDeposit()
    {
        return $this->get('total_deposit');
    }

    /**
     * @return string
     */
    public function getDepositType()
    {
        return $this->get('deposit_type');
    }

    /**
     * @return int
     */
    public function getWithdraw()
    {
        return $this->get('withdraw');
    }

    /**
     * @return string
     */
    public function getConnConfig()
    {
        return $this->get('conn_config');
    }

    /**
     * @return array
     */
    public function getVendor()
    {
        return $this->get('vendor');
    }

    /**
     * @inheritdoc
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
            'id'            => 'required|integer',
            'name'          => 'required|string|between:1,20',
            'status'        => 'sometimes|required|string|' . Rule::in(PaymentManageStatusConstants::enum()),
            'min_deposit'   => 'required|integer|digits_between:1,8|max:' . ($this->getMaxDeposit() - 1),
            'max_deposit'   => 'required|integer|digits_between:1,8',
            'total_deposit' => 'required|integer|digits_between:1,8',
            'deposit_type'  => 'sometimes|required|string|' . Rule::in(PaymentManageDepositTypeConstants::enum()),
            'withdraw'      => 'required|integer|digits_between:1,8',
            'vendor'        => 'required|string|' . Rule::in(PaymentManageVendorsCodeConstants::enum()),
            'conn_config'   => 'required|array',
            'conn_config.*' => 'required|string',
        ];
    }
}
