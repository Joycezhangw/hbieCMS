<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUcMemberExtendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uc_member_extend', function (Blueprint $table) {
            $table->bigIncrements('extend_id');
            $table->unsignedBigInteger('uid')->default(0)->index('idx_member_uid')->comment('用户id');
            $table->unsignedInteger('app_id')->default(0)->index('idx_app_id')->comment('内部应用appid');
            $table->string('extend_uniqueid')->default('')->comment('第三方登录唯一id');
            $table->enum('extend_uniqueid_type',['openid'])->default('openid')->index('idx_member_extend_uniqueid_type')->comment('第三方唯一标识类型。可选值：openid');
            $table->enum('extend_from',['weapp','aiapp'])->default('weapp')->index('idx_member_extend_from')->comment('登录来源。可选值:weapp(微信小程序),aiapp(支付宝小程序)');
            $table->string('extend_remark',512)->default('')->comment('备注');
            $table->string('extend_api_token')->default('')->comment('接口token');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `uc_member_extend` comment '用户第三方授权登录扩展'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `uc_member_extend` AUTO_INCREMENT=10001");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uc_member_extend');
    }
}
