<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionsAddFeeList extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        /** @var EloquentRole $role */
        $role = EloquentRole::query()->where('slug', RolesConstants::USER)->first();
        $role->addPermission(PermissionSubjectConstants::CHANNEL_FEE_LIST);
        $role->save();
    }

    /**
     * @return void
     */
    public function down()
    {
        /** @var EloquentRole $role */
        $role = EloquentRole::query()->where('slug', RolesConstants::USER)->first();
        $role->removePermission(PermissionSubjectConstants::CHANNEL_FEE_LIST);
        $role->save();
    }
}
