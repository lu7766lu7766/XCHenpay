<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionsAddCallNotify extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        /** @var EloquentRole $role */
        $role = EloquentRole::query()->where('slug', RolesConstants::ADMIN)->first();
        $role->addPermission(PermissionSubjectConstants::CALL_NOTIFY);
        $role->save();
    }

    /**
     * @return void
     */
    public function down()
    {
        /** @var EloquentRole $role */
        $role = EloquentRole::query()->where('slug', RolesConstants::ADMIN)->first();
        $role->removePermission(PermissionSubjectConstants::CALL_NOTIFY);
        $role->save();
    }
}
