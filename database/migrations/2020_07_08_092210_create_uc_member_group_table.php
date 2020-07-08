<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUcMemberGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uc_member_group', function (Blueprint $table) {
            $table->increments('group_id');
            $table->string('group_title',30)->default('')->comment('用户组头衔');
            $table->enum('group_type', ['system', 'special', 'member'])->index('idx_member_group_type')->comment('用户组类型');
            $table->unsignedTinyInteger('is_system')->default(0)->comment('是否系统管理组[0:否;1:是]');
            $table->unsignedTinyInteger('is_default')->default(0)->comment('是否默认[1 是, 0 否]，默认不可任何操作');
            $table->string('group_remark',500)->default('')->comment('备注');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `uc_member_group` comment '用户组'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uc_member_group');
    }
}
