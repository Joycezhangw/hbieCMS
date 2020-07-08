<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysSlideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_slide', function (Blueprint $table) {
            $table->increments('slide_id');
            $table->string('slide_name',60)->default('')->comment('幻灯片名称');
            $table->string('slide_pic')->default('幻灯片图片地址');
            $table->string('slide_page')->default('小程序跳转地址');
            $table->unsignedTinyInteger('is_show')->default(1)->comment('是否展示[1 是 0 否]');
            $table->string('slide_desc',512)->default('')->comment('幻灯片描述');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `sys_slide` comment '幻灯片'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_slide');
    }
}
