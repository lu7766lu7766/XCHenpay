<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateUserPermissionAddListenerOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var EloquentRole $user */
        $user = Sentinel::getRoleRepository()->findBySlug(RolesConstants::USER);
        $user->addPermission(PermissionSubjectConstants::USER_ORDER_LISTENER);
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /** @var EloquentRole $user */
        $user = Sentinel::getRoleRepository()->findBySlug(RolesConstants::USER);
        $user->removePermission(PermissionSubjectConstants::USER_ORDER_LISTENER);
        $user->save();
    }
}
