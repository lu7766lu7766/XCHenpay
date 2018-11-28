<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/11/21
 * Time: 下午 05:43
 */

namespace App\Http\Requests\Account;

use App\Http\Requests\HandleInvalidRequest;
use Illuminate\Validation\Rule;

class GetAccountRequest extends HandleInvalidRequest
{
    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->request['user_id'];
    }

    /**
     * @return string|null
     */
    public function getSearch()
    {
        return $this->request['search'] ?? null;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->request['page'] ?? 1;
    }

    /**
     * @return int
     */
    public function getPerpage()
    {
        return $this->request['perpage'] ?? 20;
    }

    /**
     * @return string
     */
    public function getSort()
    {
        return $this->request['sort'];
    }

    /**
     * Request args validate rules.
     * @link https://laravel.com/docs/master/validation lookup link and know how to write rule.
     * @return array
     * @see https://laravel.com/docs/master/validation#available-validation-rules checkout this to get more rule keyword info
     */
    protected function rules()
    {
        return [
            'user_id' => 'required|integer',
            'search'  => 'sometimes|required|string',
            'page'    => 'sometimes|required|integer|min:1',
            'perpage' => 'sometimes|required|integer|between:1,100',
            'sort'    => 'required|' . Rule::in(['ASC', 'DESC']),
        ];
    }

    /**
     * Request args validate msg on fail.
     * @link https://laravel.com/docs/master/validation lookup link and know how to write message.
     * @return array
     * @see https://laravel.com/docs/master/validation#customizing-the-error-messages checkout this to get more message info
     * @see https://laravel.com/docs/master/validation#working-with-error-messages checkout this to get more message info
     */
    protected function messages()
    {
        return [
            'user_id.required' => 'user_id为必填',
            'user_id.integer'  => 'user_id为int',
            'search.string'    => 'search为string',
            'page.integer'     => 'page为int',
            'page.min'         => 'page最小为1',
            'perpage.integer'  => 'perpage为int',
            'perpage.between'  => 'perpage为1~100之间',
            'sort.required'    => 'sort为必填',
            'sort.in'          => 'sort不支援',
        ];
    }
}
