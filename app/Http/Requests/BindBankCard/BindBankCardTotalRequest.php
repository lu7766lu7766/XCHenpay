<?php

namespace App\Http\Requests\BindBankCard;

use Illuminate\Foundation\Http\FormRequest;

class BindBankCardTotalRequest extends FormRequest
{
    /**
     * @return string|null
     */
    public function getSearch()
    {
        return $this->get('search', null);
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return $this->get('status', null);
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
            'search' => 'sometimes|required|string',
            'status' => 'sometimes|required|string',
        ];
    }
}
