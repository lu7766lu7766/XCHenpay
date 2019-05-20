<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/10
 * Time: 下午 05:29
 */

namespace App\Http\Requests\Listener\Setting;

use App\Http\Requests\HandleInvalidRequest;

class BankTemplateInfoRequest extends HandleInvalidRequest
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->request['id'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer'
        ];
    }

    /**
     * @inheritdoc
     * @return  array
     */
    protected function messages()
    {
        return [
            'id.required' => 'id必填',
        ];
    }
}
