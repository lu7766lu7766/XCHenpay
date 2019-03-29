<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use Illuminate\Database\Migrations\Migration;

class AddListenerRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $listener = Sentinel::registerAndActivate([
            'email'    => 'listener@henpay.net',
            'password' => "arxingkeyhonggun",
        ]);
        $listenerRole = Sentinel::getRoleRepository()->createModel()->create([
            'name'        => '监听机器人',
            'slug'        => RolesConstants::LISTENER,
            'permissions' => [
                PermissionSubjectConstants::LISTENER => true
            ],
        ]);
        $listener->roles()->attach($listenerRole);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $listener = Sentinel::findByCredentials(['login' => 'listener@henpay.net']);
        $listenerRole = Sentinel::findRoleByName('监听机器人');
        $listenerRole->delete();
        $listener->forcedelete();
        Activation::remove($listener);
    }
}
