<?php
/**
* Language file for user error/success messages
*
*/

return [

    'user_exists'              => '该用户已经存在！',
    'user_not_found'           => '用户 [:id] 不存在',
    'user_login_required'      => 'The login field is required',
    'user_password_required'   => 'The password is required.',
    'insufficient_permissions' => 'Insufficient Permissions.',
    'banned'              => 'banned',
    'suspended'             => 'suspended',

    'success' => [
        'create'    => '用户成功创建。',
        'update'    => '用户已成功更新。',
        'delete'    => '用户已成功更新。',
        'ban'       => 'Company was successfully banned.',
        'unban'     => 'Company was successfully unbanned.',
        'suspend'   => 'Company was successfully suspended.',
        'unsuspend' => 'Company was successfully unsuspended.',
        'restored'  => '成功恢复用户。',
    ],

    'error' => [
        'create'    => 'There was an issue creating the user. Please try again.',
        'update'    => 'There was an issue updating the user. Please try again.',
        'delete'    => 'There was an issue deleting the user. Please try again.',
        'unsuspend' => 'There was an issue unsuspending the user. Please try again.',
        'file_type_error'   => 'Only jpg, jpeg, bmp, png extensions are allowed.',
        'illegal_operation' => 'User Illegal operation.'
    ],

];

