<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysMpPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_mp_pages', function (Blueprint $table) {
            $table->bigIncrements('page_id');
            $table->string('page_title',10)->default('')->comment('标题');
            $table->string('page_icon')->default('')->comment('图标');
            $table->string('page_url')->default('')->comment('路由');
            $table->unsignedInteger('page_sort')->default('0')->comment('排序');
            $table->boolean('is_show')->default(true)->comment('是否展示');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `sys_mp_pages` comment '首页九宫格'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `sys_mp_pages` AUTO_INCREMENT=100001");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_mp_pages');
    }
}
