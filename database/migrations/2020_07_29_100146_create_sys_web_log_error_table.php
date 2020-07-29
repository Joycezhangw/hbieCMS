<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysWebLogErrorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_web_log_error', function (Blueprint $table) {
            $table->bigIncrements('error_id');
            $table->string('message',5000)->default('')->comment('错误信息');
            $table->string('source_module',20)->default('')->comment('来源模块');
            $table->string('source')->default('')->comment('来源');
            $table->unsignedInteger('lineno')->default(0)->comment('行号');
            $table->unsignedInteger('colno')->default(0)->comment('列数');
            $table->string('stack',10000)->default('')->comment('错误堆');
            $table->string('href')->default('')->comment('url');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `sys_web_log_error` comment '前端错误日志'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `sys_web_log_error` AUTO_INCREMENT=10001");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_web_log_error');
    }
}
