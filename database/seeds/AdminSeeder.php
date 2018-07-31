<?php

use Faker\Factory;
use App\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends DatabaseSeeder {

	public function run()
	{
		DB::table('users')->truncate(); // Using truncate function so all info will be cleared when re-seeding.
		DB::table('roles')->truncate();
		DB::table('role_users')->truncate();
		DB::table('activations')->truncate();

		$admin = Sentinel::registerAndActivate(array(
			'email'       => 'admin@admin.com',
			'password'    => "admin",
		));

        $ser = Sentinel::registerAndActivate(array(
            'email'       => 'ser@ser.com',
            'password'    => "ser",
        ));

        $fan = Sentinel::registerAndActivate(array(
            'email'       => 'fan@fan.com',
            'password'    => "fan",
        ));

        $testUser = Sentinel::registerAndActivate(array(
            'email'       => 'UUU@uuu.com',
            'password'    => "unmdzsen",
            'company_service_id' => "cdaecb46830eb3cb920d8b9856e6438e",
            'sceret_key'  => "97bc26ce95637a9114fce9d72bde884f",
            'company_name'=> "99_API_test",
            'lend_fee'    => 0.0002,
        ));

        $adminRole = Sentinel::getRoleRepository()->createModel()->create([
			'name' => 'Admin',
			'slug' => 'admin',
			'permissions' => array(
                'users' => true,
                'lendApply' => true,
                'lendManage' => true,
                'activity_log' => true,

                'users.dataSwitch' => true,
            ),
		]);

        $ServiceRole = Sentinel::getRoleRepository()->createModel()->create([
            'name'  => 'Customer service',
            'slug'  => 'customer_service',
            'permissions' => array(
                'users.index' => false,
                'users.data' => false,
                'users.show' => false,
                'users.edit' => false,
                'users.update' => false,
                'users.updateProfile' => false,
                'users.create' => false,
                'users.store' => false,
                'users.getModalDelete' => false,
                'users.destroy' => false,
                'users.getDeletedUsers' => false,
                'users.getRestore' => false,
                'users.passwordreset' => false,
                'users.dataSwitch' => true,

                'users.account'  => false,

                'showLending' => false,
                'lendApply' => true,
                'lendManage' => false,
            ),
        ]);

        $fanRole = Sentinel::getRoleRepository()->createModel()->create([
            'name'  => 'Finance',
            'slug'  => 'finance',
            'permissions' => array(
                'users.index' => false,
                'users.data' => false,
                'users.show' => false,
                'users.edit' => false,
                'users.update' => false,
                'users.updateProfile' => false,
                'users.create' => false,
                'users.store' => false,
                'users.getModalDelete' => false,
                'users.destroy' => false,
                'users.getDeletedUsers' => false,
                'users.getRestore' => false,
                'users.passwordreset' => false,
                'users.dataSwitch' => true,

                'users.account'  => false,

                'showLending' => false,
                'lendApply' => false,
                'lendManage' => true,
            ),
        ]);

        $userRole = Sentinel::getRoleRepository()->createModel()->create([
			'name'  => 'User',
			'slug'  => 'user',
            'permissions' => array(
                'users.index' => false,
                'users.data' => false,
                'users.show' => false,
                'users.edit' => false,
                'users.update' => false,
                'users.updateProfile' => false,
                'users.create' => false,
                'users.store' => false,
                'users.getModalDelete' => false,
                'users.destroy' => false,
                'users.getDeletedUsers' => false,
                'users.getRestore' => false,
                'users.passwordreset' => false,
                'users.account'  => true,

                'showLending' => true,
                'lendApply' => false,
                'lendManage' => false,
            ),
		]);


		$admin->roles()->attach($adminRole);
        $ser->roles()->attach($ServiceRole);
        $fan->roles()->attach($fanRole);
        $testUser->roles()->attach($userRole);

		$this->command->info('Admin User created with username admin@admin.com and password admin');
	}

}