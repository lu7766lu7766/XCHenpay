<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/9
 * Time: 下午 02:36
 */

namespace App\Http\Requests\Listener\Setting;

use App\Constants\Common\StatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BankTemplateRequest extends FormRequest
{
    /**
     * @return int
     */
    public function getBankId()
    {
        return $this->get('bank_id', null);
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return $this->get('status', null);
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
            'id'      => 'sometimes|required|integer',
            'status'  => 'sometimes|required|string|' . Rule::in(StatusConstants::enum()),
            'page'    => 'sometimes|required|integer|min:1',
            'perpage' => 'sometimes|required|integer|between:1,100',
        ];
    }
}
