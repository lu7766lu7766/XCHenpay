<?php

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Migrations\Migration;

class AddFillOrderPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var EloquentRole $finance */
        $finance = Sentinel::getRoleRepository()->findBySlug(RolesConstants::FINANCE);
        $finance->addPermission(PermissionSubjectConstants::FILL_ORDER);
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
        $finance = Sentinel::getRoleRepository()->findBySlug(RolesConstants::FINANCE);
        $finance->removePermission(PermissionSubjectConstants::FILL_ORDER);
        $finance->save();
    }
}
