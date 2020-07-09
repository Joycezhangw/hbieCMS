<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUcMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uc_member', function (Blueprint $table) {
            $table->bigIncrements('uid');
            $table->string('username', 60)->default('')->comment('用户名');
            $table->string('nickname', 60)->default('')->comment('昵称');
            $table->string('realname', 60)->default('')->comment('真实姓名');
            $table->string('password')->default('')->comment('密码');
            $table->string('user_mobile', 20)->default('')->comment('手机号');
            $table->char('user_salt', 6)->default('')->comment('密码加密盐');
            $table->char('user_email', 180)->default('')->comment('email');
            $table->string('user_avatar')->default('')->comment('头像');
            $table->unsignedTinyInteger('user_state')->default(1)->comment('用户状态[1:正常,0:停用]');
            $table->bigInteger('reg_ip')->default(0)->comment('注册ip');
            $table->enum('user_type', ['system', 'special', 'member'])->index('idx_member_user_type')->comment('用户类型');
            $table->unsignedInteger('reg_date')->default(0)->comment('注册时间');
            $table->bigInteger('last_login_ip')->default(0)->comment('上次登录的IP(程序转换成数值类型)');
            $table->unsignedInteger('last_login_time')->default(0)->comment('上次登录时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');

            $table->unique('username', 'uk_member_username');
            $table->unique('user_mobile', 'uk_member_user_mobile');
            $table->unique('user_email', 'uk_member_user_email');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `uc_member` comment '用户'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `uc_member` AUTO_INCREMENT=100001");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uc_member');
    }
}
