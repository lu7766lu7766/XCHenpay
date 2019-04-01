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
 * @todo class name change to BankCardOrders or BankCardList 這類順向描述的命名
 * Class OrderOfBankCardRequest
 * @package App\Http\Requests\Listener
 */
class OrderOfBankCardRequest extends FormRequest
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->get('id');
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
            'id' => 'required|integer',
        ];
    }
}
