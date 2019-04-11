<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionAddReportSearch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var EloquentRole $admin */
        $admin = Sentinel::getRoleRepository()->findBySlug(RolesConstants::ADMIN);
        $admin->removePermission('search');
        $admin->addPermission(PermissionSubjectConstants::REPORT_SEARCH);
        $admin->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /** @var EloquentRole $admin */
        $admin = Sentinel::getRoleRepository()->findBySlug(RolesConstants::ADMIN);
        $admin->removePermission(PermissionSubjectConstants::REPORT_SEARCH);
        $admin->addPermission('search');
        $admin->save();
    }
}
