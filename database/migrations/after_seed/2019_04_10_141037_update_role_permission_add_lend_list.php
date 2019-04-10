<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionAddLendList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var EloquentRole $finance */
        $finance = Sentinel::getRoleRepository()->findBySlug(RolesConstants::USER);
        $finance->addPermission(PermissionSubjectConstants::LEND_LIST);
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
        $finance = Sentinel::getRoleRepository()->findBySlug(RolesConstants::USER);
        $finance->removePermission(PermissionSubjectConstants::LEND_LIST);
        $finance->save();
    }
}
