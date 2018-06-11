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

        $user = Sentinel::registerAndActivate(array(
            'email'       => 'CCC@mail.com',
            'password'    => "123",
            'first_name'  => 'CCC',
            'last_name'   => 'hen',
        ));

        $adminRole = Sentinel::getRoleRepository()->createModel()->create([
			'name' => 'Admin',
			'slug' => 'admin',
			'permissions' => array(
                'users' => true,
                'companies' => true,
                'auth_code' => true,
                'activity_log' => true,
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
                'users.create' => false,
                'users.store' => false,
                'users.getModalDelete' => false,
                'users.destroy' => false,
                'users.getDeletedUsers' => false,

                'companies.index' => false,
                'companies.data' => false,
                'companies.show' => false,
                'companies.edit' => false,
                'companies.update' => false,
                'companies.create' => false,
                'companies.store' => false,
                'companies.getModalDelete' => false,
                'companies.destroy' => false,
                'companies.getDeletedCompanies' => false,
            ),
		]);


		$admin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);

		$this->command->info('Admin User created with username admin@admin.com and password admin');
	}

}