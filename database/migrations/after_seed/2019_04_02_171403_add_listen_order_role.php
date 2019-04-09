<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\Models\Role;
use App\User;
use Illuminate\Database\Migrations\Migration;

class AddListenOrderRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var User $listener */
        $listener = Sentinel::registerAndActivate([
            'email'    => 'listener@henpay.net',
            'password' => "arxingkeyhonggun",
        ]);
        /** @noinspection PhpUndefinedMethodInspection */
        $listenerRole = Sentinel::getRoleRepository()->createModel()->create([
            'name'        => '监听机器人',
            'slug'        => RolesConstants::LISTENER,
            'permissions' => [
                PermissionSubjectConstants::LISTENER_ORDER => true
            ],
        ]);
        $listener->roles()->attach($listenerRole);
    }

    /**
     * Reverse the migrations.
     * @return void
     * @throws Exception
     */
    public function down()
    {
        /** @var User $listener */
        /** @noinspection PhpUndefinedMethodInspection */
        $listener = Sentinel::findByCredentials(['login' => 'listener@henpay.net']);
        /** @var Role $listenerRole */
        /** @noinspection PhpUndefinedMethodInspection */
        $listenerRole = Sentinel::findRoleByName('监听机器人');
        $listenerRole->delete();
        $listener->forcedelete();
        Activation::remove($listener);
    }
}
