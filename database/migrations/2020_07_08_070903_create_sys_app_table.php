<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_app', function (Blueprint $table) {
            $table->increments('app_id');
            $table->string('app_name',60)->default('')->comment('应用名称');
            $table->string('app_desc',512)->default('')->comment('应用描述');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `sys_app` comment '内部应用信息'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `sys_app` AUTO_INCREMENT=100001");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_app');
    }
}
