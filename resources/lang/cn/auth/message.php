<?php
/**
* Language file for auth error messages
*
*/

return array(

    'account_already_exists' => '此电子邮件的帐户已存在',
    'account_not_found' => '电子邮件或密码不正确',
    'account_email_not_found' =>'电子邮件不正确',
    'account_not_activated'  => '该用户帐户未被激活',
    'account_suspended'      => '系统帐户因登录尝试过多而被暂停。 请在 [:delay] 秒后再试一次',
    'account_banned'         => '该用户帐号已被禁止',

    'signin' => array(
        'error'   => '尝试登录时出现问题，请重试。',
        'success' => '您已成功登录',
    ),

    'login' => array(
        'error'   => '尝试登录时出现问题，请重试。',
        'success' => '您已成功登录',
    ),

    'signup' => array(
        'error'   => '尝试创建帐户时出现问题，请重试。',
        'success' => '帐户已成功创建',
    ),

        'forgot-password' => array(
            'error'   => '尝试获取重置密码时出现问题，请重试。',
            'success' => '密码恢复邮件已成功发送。',
        ),

        'forgot-password-confirm' => array(
            'error'   => '尝试重置密码时出现问题，请重试。',
            'success' => '您的密码已成功重置。',
        ),

    'activate' => array(
        'error'   => '试图激活您的帐户时出现问题，请重试。',
        'success' => '您的帐户已成功激活。',
    ),

    'contact' => array(
        'error'   => '尝试提交联系表单时出现问题，请重试。',
        'success' => '您的联系方式已成功发送。',
    ),
);
