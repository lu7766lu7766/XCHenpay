<?php

class AdminSeeder extends DatabaseSeeder
{
    public function run()
    {
        DB::table('users')->truncate(); // Using truncate function so all info will be cleared when re-seeding.
        DB::table('roles')->truncate();
        DB::table('role_users')->truncate();
        DB::table('activations')->truncate();
        DB::table('payment_fees')->truncate();
        $admin = Sentinel::registerAndActivate([
            'email'    => 'admin@admin.com',
            'password' => "admin",
        ]);
        $ser = Sentinel::registerAndActivate([
            'email'    => 'ser@ser.com',
            'password' => "ser",
        ]);
        $fan = Sentinel::registerAndActivate([
            'email'    => 'fan@fan.com',
            'password' => "fan",
        ]);
        $testUser = Sentinel::registerAndActivate([
            'email'              => 'UUU@uuu.com',
            'password'           => "unmdzsen",
            'company_service_id' => "cdaecb46830eb3cb920d8b9856e6438e",
            'sceret_key'         => "97bc26ce95637a9114fce9d72bde884f",
            'company_name'       => "99_API_test",
            'lend_fee'           => 0.0002,
        ]);
        $adminRole = Sentinel::getRoleRepository()->createModel()->create([
            'name'        => '管理者',
            'slug'        => 'admin',
            'permissions' => [
                'logQuery'     => true,
                'users'        => true,
                'lendApply'    => true,
                'lendManage'   => true,
                'activity_log' => true,
                'account'      => true,
                'users.dataSwitch' => true,
            ],
        ]);
        $ServiceRole = Sentinel::getRoleRepository()->createModel()->create([
            'name'        => '客服',
            'slug'        => 'customer_service',
            'permissions' => [
                'users.index'           => false,
                'users.data'            => false,
                'users.show'            => false,
                'users.edit'            => false,
                'users.update'          => false,
                'users.updateProfile'   => false,
                'users.create'          => false,
                'users.store'           => false,
                'users.getModalDelete'  => false,
                'users.destroy'         => false,
                'users.getDeletedUsers' => false,
                'users.getRestore'      => false,
                'users.passwordreset'   => false,
                'users.dataSwitch'      => true,
                'account.index'            => true,
                'account.accountData'      => true,
                'account.getAccountDelete' => true,
                'account.destroy'          => true,
                'account.createAccount'    => false,
                'account.sendVerifyCode'   => false,
                'account.addAccount'       => false,
                'showLending' => false,
                'lendApply'   => true,
                'lendManage'  => false,
            ],
        ]);
        $fanRole = Sentinel::getRoleRepository()->createModel()->create([
            'name'        => '财务',
            'slug'        => 'finance',
            'permissions' => [
                'users.index'           => false,
                'users.data'            => false,
                'users.show'            => false,
                'users.edit'            => false,
                'users.update'          => false,
                'users.updateProfile'   => false,
                'users.create'          => false,
                'users.store'           => false,
                'users.getModalDelete'  => false,
                'users.destroy'         => false,
                'users.getDeletedUsers' => false,
                'users.getRestore'      => false,
                'users.passwordreset'   => false,
                'users.dataSwitch'      => true,
                'account.index'            => true,
                'account.accountData'      => true,
                'account.getAccountDelete' => true,
                'account.destroy'          => true,
                'account.createAccount'    => false,
                'account.sendVerifyCode'   => false,
                'account.addAccount'       => false,
                'showLending' => false,
                'lendApply'   => false,
                'lendManage'  => true,
            ],
        ]);
        $userRole = Sentinel::getRoleRepository()->createModel()->create([
            'name'        => '商户',
            'slug'        => 'user',
            'permissions' => [
                'users.index'           => false,
                'users.data'            => false,
                'users.show'            => false,
                'users.edit'            => false,
                'users.update'          => false,
                'users.updateProfile'   => false,
                'users.create'          => false,
                'users.store'           => false,
                'users.getModalDelete'  => false,
                'users.destroy'         => false,
                'users.getDeletedUsers' => false,
                'users.getRestore'      => false,
                'users.passwordreset'   => false,
                'account.index'            => false,
                'account.accountData'      => true,
                'account.getAccountDelete' => true,
                'account.destroy'          => true,
                'account.createAccount'    => true,
                'account.sendVerifyCode'   => true,
                'account.addAccount'       => true,
                'showLending' => true,
                'lendApply'   => false,
                'lendManage'  => false,
            ],
        ]);
        $admin->roles()->attach($adminRole);
        $ser->roles()->attach($ServiceRole);
        $fan->roles()->attach($fanRole);
        $testUser->roles()->attach($userRole);
        $this->command->info('Admin User created with username admin@admin.com and password admin');
    }
}
