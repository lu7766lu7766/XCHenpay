<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/14
 * Time: 下午 05:43
 */

namespace App\Http\Requests\Listener\Setting;

use Illuminate\Foundation\Http\FormRequest;

class BankTemplateFrontRequest extends FormRequest
{
    /**
     * @return int
     */
    public function getBankId()
    {
        return $this->get('bank_id');
    }

    /**
     * @return string
     */
    public function getRefresh()
    {
        return $this->get('refresh');
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
            'bank_id' => 'sometimes|required|integer',
            'refresh' => 'sometimes|required|string|date_format:"Y-m-d H:i:s"',
        ];
    }
}
