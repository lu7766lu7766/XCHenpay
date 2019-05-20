<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\Repositories\RoleRepo;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionAddBankTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = app(RoleRepo::class)->getBySlug(
            [
                RolesConstants::ADMIN,
                RolesConstants::CUSTOMER,
                RolesConstants::FINANCE,
                RolesConstants::LISTENER
            ]
        );
        $roles->map(function (EloquentRole $role) {
            $role->addPermission(PermissionSubjectConstants::LISTENER_SETTING_BANK_TEMPLATE);
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
            RolesConstants::FINANCE,
            RolesConstants::LISTENER
        ]);
        $roles->map(function (EloquentRole $role) {
            $role->removePermission(PermissionSubjectConstants::LISTENER_SETTING_BANK_TEMPLATE);
            $role->save();
        });
    }
}
