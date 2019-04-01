<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\Repositories\RoleRepo;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionsAddMerchants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $items = app(RoleRepo::class)->getBySlug([RolesConstants::ADMIN, RolesConstants::FINANCE]);
        $items->map(function (EloquentRole $item) {
            if ($item->slug == RolesConstants::ADMIN) {
                $item->addPermission(PermissionSubjectConstants::MERCHANTS);
                $item->addPermission(PermissionSubjectConstants::TRASHED_MERCHANTS);
            } else {
                $item->removePermission('users.getRolesList');
                $item->removePermission('users.dataTotal');
                $item->removePermission('users.data');
                $item->removePermission('users.index');
                $item->addPermission(PermissionSubjectConstants::MERCHANTS_VIEW);
            }
            $item->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $items = app(RoleRepo::class)->getBySlug([RolesConstants::ADMIN, RolesConstants::FINANCE]);
        $items->map(function (EloquentRole $item) {
            if ($item->slug == RolesConstants::ADMIN) {
                $item->removePermission(PermissionSubjectConstants::MERCHANTS);
                $item->removePermission(PermissionSubjectConstants::TRASHED_MERCHANTS);
            } else {
                $item->addPermission('users.getRolesList');
                $item->addPermission('users.dataTotal');
                $item->addPermission('users.data');
                $item->addPermission('users.index');
                $item->removePermission(PermissionSubjectConstants::MERCHANTS_VIEW);
            }
            $item->save();
        });
    }
}
