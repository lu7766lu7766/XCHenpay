<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/2
 * Time: 下午 04:22
 */

namespace App\Http\Requests\Listener;

use Illuminate\Foundation\Http\FormRequest;

class IsCallBackRequest extends FormRequest
{
    /**
     * @return string
     */
    public function getCardNo()
    {
        return $this->get('card_number');
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->get('amount');
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->get('date');
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
            'card_number' => 'required|string',
            'amount'      => 'required|numeric',
            'date'        => 'required|date_format:"Y-m-d H:i:s"',
        ];
    }
}
