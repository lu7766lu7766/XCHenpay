<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionAddReportStatistical extends Migration
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
        $user->removePermission('search.reportStatQuery');
        $user->addPermission(PermissionSubjectConstants::REPORT_STATISTICAL);
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
        $user->removePermission(PermissionSubjectConstants::REPORT_STATISTICAL);
        $user->addPermission('search.reportStatQuery');
        $user->save();
    }
}
