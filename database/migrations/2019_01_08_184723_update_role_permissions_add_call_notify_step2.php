<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionsAddCallNotifyStep2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var EloquentRole $role */
        $role = EloquentRole::query()->where('slug', RolesConstants::USER)->first();
        $role->addPermission(PermissionSubjectConstants::CALL_NOTIFY);
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
        $role = EloquentRole::query()->where('slug', RolesConstants::USER)->first();
        $role->removePermission(PermissionSubjectConstants::CALL_NOTIFY);
        $role->save();
    }
}
