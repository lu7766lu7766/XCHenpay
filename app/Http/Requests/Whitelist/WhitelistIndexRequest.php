<?php

namespace App\Http\Requests\Whitelist;

use Illuminate\Foundation\Http\FormRequest;

class WhitelistIndexRequest extends FormRequest
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
    public function getPerPage()
    {
        return $this->get('perpage', 10);
    }

    /**
     * @inheritdoc
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
            'page'    => 'sometimes|required|integer',
            'perpage' => 'sometimes|required|integer|max:100',
        ];
    }
}
