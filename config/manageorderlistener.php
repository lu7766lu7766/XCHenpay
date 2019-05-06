<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/4/9
 * Time: 下午 04:03
 */
return [
    /** 搜尋時間,單位為分(MIN) */
    'search_time'  => env('MANAGE_ORDER_LISTENER_SEARCH_TIME', 10),
    /** 訂單比對時間,單位為分(MIN) */
    'compare_time' => env('MANAGE_ORDER_LISTENER_COMPARE_TIME', 10),
];
