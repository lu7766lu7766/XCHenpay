<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionsAddNotifyOrderFail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var EloquentRole $role */
        $role = Cartalyst\Sentinel\Roles\EloquentRole::query()->where('slug', RolesConstants::ADMIN)->first();
        $role->addPermission(PermissionSubjectConstants::NOTIFY_ORDER_FAIL);
        $role->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /** @var EloquentRole $role */
        $role = Cartalyst\Sentinel\Roles\EloquentRole::query()->where('slug', RolesConstants::ADMIN)->first();
        $role->removePermission(PermissionSubjectConstants::NOTIFY_ORDER_FAIL);
        $role->save();
    }
}
