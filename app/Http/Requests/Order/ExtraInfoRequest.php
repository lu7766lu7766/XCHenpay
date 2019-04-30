<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/4/18
 * Time: 下午 03:15
 */

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class ExtraInfoRequest extends FormRequest
{
    /**
     * @return string
     */
    public function getTradeSeq()
    {
        return $this->get('trade_seq');
    }

    /**
     * @return string
     */
    public function getAccount()
    {
        return $this->get('account');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'trade_seq' => 'required|string',
            'account'   => 'required|digits_between:4,4'
        ];
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
