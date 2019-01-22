<?php

namespace App\Http\Requests\BindBankCard;

use App\Constants\Account\AccountStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BindBankCardIndexRequest extends FormRequest
{
    /**
     * @return string|null
     */
    public function getSearch()
    {
        return $this->get('search', null);
    }

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
        return $this->get('perpage', 20);
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return $this->get('status', null);
    }

    /**
     * @return string
     */
    public function getSort()
    {
        return $this->get('status', 'DESC');
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'search'  => 'sometimes|required|string',
            'page'    => 'sometimes|required|integer|min:1',
            'perpage' => 'sometimes|required|integer|between:1,100',
            'status'  => 'sometimes|required|string|' . Rule::in(AccountStatusConstants::enum()),
            'sort'    => 'sometimes|required|' . Rule::in(['ASC', 'DESC']),
        ];
    }
}
