<?php

namespace App\Http\Requests\Merchant;

use App\Constants\User\UserApplyStatusConstants;
use App\Constants\User\UserStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MerchantsIndexRequest extends FormRequest
{
    /**
     * @return int
     */
    public function getPage()
    {
        return $this->get('page', 1);
    }

    /**
     * @return int
     */
    public function getPerpage()
    {
        return $this->get('perpage', 10);
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return $this->get('status', null);
    }

    /**
     * @return string|null
     */
    public function getApplyStatus()
    {
        return $this->get('apply_status', null);
    }

    /**
     * @return string|null
     */
    public function getKeyword()
    {
        return $this->get('keyword', null);
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'page'         => 'sometimes|required|integer',
            'perpage'      => 'sometimes|required|integer|max:100',
            'status'       => 'sometimes|required|' . Rule::in(UserStatusConstants::enum()),
            'apply_status' => 'sometimes|required|' . Rule::in(UserApplyStatusConstants::enum()),
            'keyword'      => 'sometimes|required|string'
        ];
    }
}
