<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/2/12
 * Time: 下午 02:32
 */

namespace App\Http\Requests\BankCardGateway;

use Illuminate\Foundation\Http\FormRequest;

class GatewayRequest extends FormRequest
{
    /**
     * @return string
     */
    public function getTradeSeq()
    {
        return $this->get('trade_seq');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'trade_seq' => 'required|string'
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
