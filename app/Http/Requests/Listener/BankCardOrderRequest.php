<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/29
 * Time: 下午 03:48
 */

namespace App\Http\Requests\Listener;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class OrderOfBankCardRequest
 * @package App\Http\Requests\Listener
 */
class BankCardOrderRequest extends FormRequest
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->get('id');
    }

    /**
     * @return int|null
     */
    public function getPayState()
    {
        return $this->get('pay_state') ?? null;
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
            'id'        => 'required|integer',
            'pay_state' => 'sometimes|required|integer',
        ];
    }
}
