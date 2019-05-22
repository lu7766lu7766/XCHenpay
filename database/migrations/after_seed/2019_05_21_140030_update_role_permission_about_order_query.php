<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\Repositories\RoleRepo;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionAboutOrderQuery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = app(RoleRepo::class)->getBySlug([
            RolesConstants::ADMIN,
            RolesConstants::CUSTOMER,
            RolesConstants::FINANCE
        ]);
        $roles->map(function (EloquentRole $role) {
            $role->addPermission(PermissionSubjectConstants::ORDER_QUERY_MANAGE);
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
        $roles = app(RoleRepo::class)->getBySlug([
            RolesConstants::ADMIN,
            RolesConstants::CUSTOMER,
            RolesConstants::FINANCE
        ]);
        $roles->map(function (EloquentRole $role) {
            $role->removePermission(PermissionSubjectConstants::ORDER_QUERY_MANAGE);
            $role->save();
        });
    }
}
