<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionAddSystemSettingUserManage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var EloquentRole $finance */
        $finance = Sentinel::getRoleRepository()->findBySlug(RolesConstants::ADMIN);
        $finance->addPermission(PermissionSubjectConstants::USER_MANAGE);
        $finance->removePermission('systemSetting');
        $finance->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /** @var EloquentRole $finance */
        $finance = Sentinel::getRoleRepository()->findBySlug(RolesConstants::ADMIN);
        $finance->removePermission(PermissionSubjectConstants::USER_MANAGE);
        $finance->addPermission('systemSetting');
        $finance->save();
    }
}
