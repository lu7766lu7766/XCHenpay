<?php
/**
 * Created by PhpStorm.
 * User: House
 * Date: 2018/12/27
 * Time: 下午 02:08
 */

namespace App\Exceptions;

class ApiErrorScalarCodeException extends \Exception
{
    private $scalarCode;

    /**
     * ApiErrorStringCodeException constructor.
     * @param string $message
     * @param string|int $code
     */
    public function __construct(string $message = "", $code = 0)
    {
        $this->scalarCode = $code;
        parent::__construct($message, 200, null);
    }

    /**
     * @return int|string
     */
    public function getScalarCode()
    {
        return $this->scalarCode;
    }

    public function report()
    {
    }
}
