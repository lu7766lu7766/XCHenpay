<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/31
 * Time: 上午 11:08
 */

namespace App\Service;

abstract class AbstractBankCardDetector
{
    /**
     * @param string $cardNo 卡號
     * @return array
     */
    abstract public function mining(string $cardNo): array;
}
