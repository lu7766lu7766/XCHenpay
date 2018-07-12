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
			'first_name'  => 'Admin',
			'last_name'   => 'Wang',
		));

        $fan = Sentinel::registerAndActivate(array(
            'email'       => 'fan@fan.com',
            'password'    => "fan",
            'first_name'  => 'Fan',
            'last_name'   => 'Liu',
        ));

//        $user = Sentinel::registerAndActivate(array(
//            'email'       => 'user@user.com',
//            'password'    => "user",
//            'first_name'  => 'User',
//            'last_name'   => 'Chen',
//        ));

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
                //'users.showProfile' => false,
                'users.edit' => false,
                //'users.editProfile' => false,
                'users.update' => false,
                'users.updateProfile' => false,
                'users.create' => false,
                'users.store' => false,
                'users.getModalDelete' => false,
                'users.destroy' => false,
                'users.getDeletedUsers' => false,
                'users.getRestore' => false,
                'users.passwordreset' => false,
//                'users.lockscreen' => false,
//                'users.postLockscreen' => false,

                'lendApply' => true,
                'lendManage' => false,
            ),
		]);


		$admin->roles()->attach($adminRole);
        $fan->roles()->attach($fanRole);
//        $user->roles()->attach($userRole);

		$this->command->info('Admin User created with username admin@admin.com and password admin');
	}

}