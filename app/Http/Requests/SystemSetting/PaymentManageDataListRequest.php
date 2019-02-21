<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/2/11
 * Time: 下午 02:31
 */

namespace App\Http\Requests\SystemSetting;

use App\Constants\PaymentManage\PaymentManageStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentManageDataListRequest extends FormRequest
{
    /**
     * @return string|null
     */
    public function getKeyword()
    {
        return $this->get('keyword', null);
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
    public function getPerPage()
    {
        return $this->get('perpage', 10);
    }

    /**
     * @inheritdoc
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
            'keyword' => 'sometimes|required|string',
            'status'  => 'sometimes|required|string|' . Rule::in(PaymentManageStatusConstants::enum()),
            'page'    => 'sometimes|required|integer|min:1',
            'perpage' => 'sometimes|required|integer|max:100',
        ];
    }
}
