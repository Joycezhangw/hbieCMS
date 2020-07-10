<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHbCmsChannelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_cms_channel', function (Blueprint $table) {
            $table->increments('channel_id');
            $table->string('channel_name',60)->default('')->comment('栏目名称');
            $table->string('channel_short_name',20)->default('')->comment('栏目简称');
            $table->unsignedInteger('pid')->default(0)->comment('上级栏目');
            $table->unsignedInteger('channel_sort')->default(0)->comment('排序');
            $table->unsignedTinyInteger('is_show')->default(1)->comment('是否显示[1 是, 0 否]');
            $table->string('channel_desc',512)->default('')->comment('栏目描述');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hb_cms_channel` comment '栏目'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hb_cms_channel` AUTO_INCREMENT=10001");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_cms_channel');
    }
}
