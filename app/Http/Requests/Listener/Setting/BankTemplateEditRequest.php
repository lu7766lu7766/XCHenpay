<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/9
 * Time: 下午 03:54
 */

namespace App\Http\Requests\Listener\Setting;

use App\Constants\Common\StatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BankTemplateEditRequest extends FormRequest
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->get('id', null);
    }

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
    public function getContents()
    {
        return $this->get('contents');
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->get('status');
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
            'id'       => 'sometimes|required|integer',
            'bank_id'  => 'required|integer',
            'contents' => 'required|string',
            'status'   => 'required|string|' . Rule::in(StatusConstants::enum()),
        ];
    }
}
