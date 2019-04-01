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
    // @todo 權限與功能無法關聯上 範圍太大,請明確命名權限subject.
    const LISTENER = 'listener';
}


