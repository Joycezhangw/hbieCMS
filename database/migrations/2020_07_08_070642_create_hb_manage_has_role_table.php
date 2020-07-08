<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHbManageHasRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_manage_has_role', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->default(0)->index('pk_manage_role_id')->comment('角色id');
            $table->unsignedInteger('manage_id')->default(0)->index('pk_manage_id')->comment('管理员id');

            $table->foreign('role_id')
                ->references('role_id')
                ->on('hb_manage_role')
                ->onDelete('cascade');

            $table->primary(['role_id',  'manage_id'],
                'manage_has_role_primary');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hb_manage_has_role` comment '管理员绑定多个角色'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_manage_has_role');
    }
}
