<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionsAddFeeManagement extends Migration
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
        $role->addPermission(PermissionSubjectConstants::CHANNEL_FEE_MANAGEMENT);
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
        $role->removePermission(PermissionSubjectConstants::CHANNEL_FEE_MANAGEMENT);
        $role->save();
    }
}
