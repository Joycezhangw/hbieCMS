<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHbManageRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_manage_role', function (Blueprint $table) {
            $table->increments('role_id')->comment('管理员角色主键id');
            $table->string('role_title',50)->default('')->comment('角色名称');
            $table->unsignedTinyInteger('is_default')->default(0)->comment('是否默认角色[1 是 0 否]');
            $table->string('role_desc',512)->default('')->comment('角色描述');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hb_manage_role` comment '管理员角色'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_manage_role');
    }
}
