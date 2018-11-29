<?php
/**
 * Created by PhpStorm.
 * User: MID-House
 * Date: 2017/3/16
 * Time: 下午 02:37
 */

namespace App\Http\Requests;

abstract class AbstractLaravelRequest
{
    /**
     * @var array
     */
    protected $request;

    /**
     * AbstractP40RequestHandle constructor.
     * @param array $request
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function __construct(array $request)
    {
        $this->request = $request;
        \Validator::make($request, $this->rules(), $this->messages())->validate();
    }

    /**
     * Request args validate rules.
     * @link https://laravel.com/docs/master/validation lookup link and know how to write rule.
     * @return array
     * @see https://laravel.com/docs/master/validation#available-validation-rules
     * checkout this to get more rule keyword info
     */
    abstract protected function rules();

    /**
     * Request args validate msg on fail.
     * @link https://laravel.com/docs/master/validation lookup link and know how to write message.
     * @return array
     * @see https://laravel.com/docs/master/validation#customizing-the-error-messages
     * checkout this to get more message info
     * @see https://laravel.com/docs/master/validation#working-with-error-messages
     * checkout this to get more message info
     */
    abstract protected function messages();

    /**
     * @param array $request
     * @return static
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function getHandle(array $request)
    {
        return new static($request);
    }
}
