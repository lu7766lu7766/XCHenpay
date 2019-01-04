<?php

namespace App\Http\Requests\TrashedMerchant;

use Illuminate\Foundation\Http\FormRequest;

class TrashedMerchantsIndexRequest extends FormRequest
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
        return $this->get('perpage', 25);
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
            'page'    => 'sometimes|required|integer',
            'perpage' => 'sometimes|required|integer|max:100',
        ];
    }
}
