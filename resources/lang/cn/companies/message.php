<?php
/**
* Language file for user error/success messages
*
*/

return [

    'company_exists'              => '该厂商已经存在！',
    'company_not_found'           => '厂商 [:id] 不存在',
    'user_login_required'      => 'The login field is required',
    'user_password_required'   => 'The password is required.',
    'insufficient_permissions' => 'Insufficient Permissions.',
    'banned'                   => 'banned',
    'suspended'                => 'suspended',

    'success' => [
        'create'    => '厂商成功创建。',
        'update'    => '厂商已成功更新。',
        'delete'    => '厂商已成功更新。',
        'ban'       => 'Company was successfully banned.',
        'unban'     => 'Company was successfully unbanned.',
        'suspend'   => 'Company was successfully suspended.',
        'unsuspend' => 'Company was successfully unsuspended.',
        'restored'  => '成功恢复厂商'
    ],

    'error' => [
        'create'    => 'There was an issue creating the company. Please try again.',
        'update'    => 'There was an issue updating the company. Please try again.',
        'delete'    => 'There was an issue deleting the company. Please try again.',
        'unsuspend' => 'There was an issue unsuspending the company. Please try again.',
        'file_type_error'   => 'Only jpg, jpeg, bmp, png extensions are allowed.',
    ],

];

