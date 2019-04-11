<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\Repositories\RoleRepo;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateListenerPermissionAddCompanyAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = app(RoleRepo::class)->getBySlug([RolesConstants::LISTENER]);
        $roles->map(function (EloquentRole $role) {
            $role->addPermission(PermissionSubjectConstants::COMPANY_ACCOUNT);
            $role->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $roles = app(RoleRepo::class)->getBySlug([RolesConstants::LISTENER]);
        $roles->map(function (EloquentRole $role) {
            $role->removePermission(PermissionSubjectConstants::COMPANY_ACCOUNT);
            $role->save();
        });
    }
}
