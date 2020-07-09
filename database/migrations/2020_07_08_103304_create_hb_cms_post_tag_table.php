<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHbCmsPostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_cms_post_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id')->default(0)->index('pk_manage_tag_id')->comment('标签id');
            $table->unsignedBigInteger('post_id')->default(0)->index('pk_post_id')->comment('内容id');

            $table->foreign('post_id')
                ->references('post_id')
                ->on('hb_cms_post')
                ->onDelete('cascade');


            $table->primary(['tag_id',  'post_id'],
                'cms_post_tag_primary');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hb_cms_post_tag` comment '内容关联标签'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_cms_post_tag');
    }
}
