<?php

namespace App\Http\Requests\FeeManagement;

use App\Constants\PaymentFee\PaymentFeeStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeeManagementStoreRequest extends FormRequest
{
    /**
     * @return float
     */
    public function getFee()
    {
        return $this->get('fee');
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->get('status');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->get('id');
    }

    /**
     * @return int
     */
    public function getMerchantId()
    {
        return $this->get('merchant_id');
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
            'status'      => 'required|' . Rule::in(PaymentFeeStatusConstants::enum()),
            'id'          => 'required|integer',
            'merchant_id' => 'required|integer',
            'fee'         => 'required|max:8|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/'
        ];
    }
}
