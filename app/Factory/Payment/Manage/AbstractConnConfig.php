<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/15
 * Time: 下午 05:46
 */

namespace App\Factory\Payment\Manage;

use App\Contract\Laravel\Validation\IDescription;

abstract class AbstractConnConfig implements IDescription
{
    /**
     * @return array
     */
    public function messages(): array
    {
        return [];
    }
}
