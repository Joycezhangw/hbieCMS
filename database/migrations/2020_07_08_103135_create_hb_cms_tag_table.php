<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHbCmsTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_cms_tag', function (Blueprint $table) {
            $table->bigIncrements('tag_id');
            $table->string('tag_name',128)->default('')->comment('标签名称');
            $table->unsignedInteger('post_num')->default(0)->comment('档案数量');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hb_cms_tag` comment '标签'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hb_cms_tag` AUTO_INCREMENT=100001");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_cms_tag');
    }
}
