<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\Repositories\RoleRepo;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionAddPersonalAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = app(RoleRepo::class)->findBySlug([RolesConstants::USER]);
        $roles->map(function (EloquentRole $role) {
            $role->addPermission(PermissionSubjectConstants::PERSONAL_ACCOUNT);
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
        $roles = app(RoleRepo::class)->findBySlug([RolesConstants::USER]);
        $roles->map(function (EloquentRole $role) {
            $role->removePermission(PermissionSubjectConstants::PERSONAL_ACCOUNT);
            $role->save();
        });
    }
}
