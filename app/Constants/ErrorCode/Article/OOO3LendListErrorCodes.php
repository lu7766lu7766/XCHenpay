<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/1/9
 * Time: 下午 05:18
 */

namespace App\Constants\ErrorCode\Article;

class OOO3LendListErrorCodes
{
    const SECURITY_CODE_ERROR = '3-0001';
    const TARGET_ID_REQUIRED = '3-0002';
    const TARGET_ID_MUST_INT = '3-0003';
    const AMOUNT_REQUIRED = '3-0004';
    const AMOUNT_MUST_INT = '3-0005';
    const OVER_LIMIT_AMOUNT_VALUE = '3-0006';
    const NOTE_MUST_STRING = '3-0007';
    const CODE_REQUIRED = '3-0008';
    const CODE_STRING = '3-0009';
    const ENABLE_WITHDRAWAL_NOT_ENOUGH = '3-0010';
    const BANK_CARD_IS_EMPTY = '3-0011';
    const PLEASE_CHECK_APPLY_PERMISSION = '3-0012';
}
