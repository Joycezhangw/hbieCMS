<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHbManageRoleHasModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_manage_role_has_module', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->default(0)->index('pk_manage_role_id')->comment('角色id');
            $table->unsignedInteger('module_id')->default(0)->index('pk_module_id')->comment('权限模块id');

            $table->foreign('role_id')
                ->references('role_id')
                ->on('hb_manage_role')
                ->onDelete('cascade');

            $table->primary(['role_id',  'module_id'],
                'manage_role_has_module_primary');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hb_manage_role_has_module` comment '角色关联权限'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_manage_role_has_module');
    }
}
