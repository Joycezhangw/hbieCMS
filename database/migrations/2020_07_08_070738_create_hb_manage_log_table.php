<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHbManageLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_manage_log', function (Blueprint $table) {
            $table->bigIncrements('log_id');
            $table->unsignedInteger('manage_id')->default(0)->comment('管理员id');
            $table->string('manage_username',50)->default('')->comment('管理员用户名');
            $table->string('log_url',1500)->default('')->comment('操作页面');
            $table->string('log_title',128)->default('')->comment('日志标题');
            $table->json('log_content')->comment('操作内容');
            $table->bigInteger('log_ip')->comment('ip地址');
            $table->string('useragent',256)->comment('User-Agent');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hb_manage_log` comment '管理员操作日志'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_manage_log');
    }
}
