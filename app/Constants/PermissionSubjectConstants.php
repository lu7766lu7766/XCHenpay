<?php
/**
 * Created by PhpStorm.
 * User: House
 * Date: 2018/12/27
 * Time: 下午 04:41
 */

namespace App\Constants;

class PermissionSubjectConstants
{
    const FILL_ORDER = 'fill_order';
    const CHANNEL_FEE_MANAGEMENT = 'channel.feeManagement';
    const CHANNEL_FEE_LIST = 'channel.feeList';
    const CALL_NOTIFY = 'logQuery.callNotify';
    const LEND_MANAGE = 'lendManage';
    const MERCHANTS = 'merchants';
    const TRASHED_MERCHANTS = 'trashed.merchants';
    const MERCHANTS_VIEW = 'merchants.view';
    const NOTIFY_ORDER_FAIL = 'notify.order.fail';
    const INFORMATION_PUBLISH = 'Information.publish';
    const INFORMATION_LIST = 'Information.list';
    const BIND_BANK_CARD = 'bank.card.bind';
    const BANK_CARD_LIST = 'bank.card.list';
    const COMPANY_ACCOUNT = 'company.account';
    const PERSONAL_ACCOUNT = 'personal.account';
    const MANAGE_ACCOUNT = 'manage.account';
    const PAYMENT_MANAGE = 'payment.manage';
    const WHITE_LIST = 'whitelist';
    const USER_MANAGE = 'system.setting.user.manage';
    const LISTENER_ORDER = 'listener.order';
    const LEND_LIST = 'lendList';
    const REPORT_SEARCH = 'report.search';
    const REPORT_STATISTICAL = 'report.statistical';
    const LISTENER_SETTING_BANK_TEMPLATE = 'listener.setting.bankTemplate';
    const USER_ORDER_LISTENER = 'user.order.listener';
    const ORDER_QUERY_DOMINATE = 'logQuery';// 訂單查詢全功能
    const ORDER_QUERY_SHOW_STATE = 'logQuery.showState';
    const ORDER_QUERY_MANAGE = 'order.query.manage';
    const ORDER_QUERY_UPDATE = 'order.query.update';
}
