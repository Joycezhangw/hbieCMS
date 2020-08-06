<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUcMemberIdentityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uc_member_identity', function (Blueprint $table) {
            $table->bigIncrements('identity_id');
            $table->unsignedInteger('app_id')->default(0)->index('idx_sys_app_id')->comment('内部应用appid');
            $table->string('identity_from', 60)->default('')->index('idx_member_identity_from')->comment('身份来源。按系统自定义可选值');
            $table->unsignedBigInteger('uid')->default(0)->index('idx_member_uid')->comment('用户id（每个身份来源只对应一个用户id）');
            $table->unsignedBigInteger('outer_iid')->default(0)->index('idx_member_identity_outer_iid')->comment('其他id（根据身份来源定位该id）');
            $table->string('identity_remark',512)->default('')->comment('备注');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `uc_member_identity` comment '用户拥有身份'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `uc_member_identity` AUTO_INCREMENT=10001");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uc_member_identity');
    }
}
