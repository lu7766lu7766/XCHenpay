<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\Repositories\RoleRepo;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionAddBankCardList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = app(RoleRepo::class)->findBySlug([RolesConstants::CUSTOMER, RolesConstants::FINANCE]);
        $roles->map(function (EloquentRole $role) {
            $role->addPermission(PermissionSubjectConstants::BANK_CARD_LIST);
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
        $roles = app(RoleRepo::class)->findBySlug([RolesConstants::CUSTOMER, RolesConstants::FINANCE]);
        $roles->map(function (EloquentRole $role) {
            $role->removePermission(PermissionSubjectConstants::BANK_CARD_LIST);
            $role->save();
        });
    }
}
