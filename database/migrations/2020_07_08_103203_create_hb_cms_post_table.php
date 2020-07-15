<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHbCmsPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_cms_post', function (Blueprint $table) {
            $table->bigIncrements('post_id');
            $table->string('post_title',80)->default('')->comment('文章标题');
            $table->unsignedInteger('channel_id')->default(0)->comment('栏目id');
            $table->string('channel_ids_path',512)->default('')->comment('栏目id路径');
            $table->string('channel_name_path',1024)->default('')->comment('栏目名称路径');
            $table->unsignedInteger('manage_id')->default(0)->comment('管理员发布者id');
            $table->string('manage_username',60)->default('')->comment('管理员发布者名');
            $table->unsignedBigInteger('author_uid')->default(0)->comment('作者用户id');
            $table->string('author_username',60)->default('')->comment('作者用户名,后期合并管理员和用户可用');
            $table->string('post_tags',1512)->default('')->comment('TAG标签值,利于搜索,值之间用应用逗号隔开');
            $table->string('post_pic')->default('')->comment('文章封面图片');
            $table->string('post_desc',512)->default('')->comment('简短的文章描述');
            $table->unsignedInteger('post_like')->default(0)->comment('点赞数量');
            $table->unsignedInteger('post_dislike')->default(0)->comment('点踩数量');
            $table->unsignedInteger('post_view')->default(0)->comment('查看数量');
            $table->unsignedInteger('post_fav')->default(0)->comment('收藏数量');
            $table->unsignedInteger('post_comment')->default(0)->comment('评论数量');
            $table->unsignedTinyInteger('is_comment')->default(1)->comment('是否允许评论[1 是 0 否]');
            $table->unsignedTinyInteger('is_guest')->default(1)->comment('是否访客可见[1 是 0 否]');
            $table->unsignedTinyInteger('is_home_rec')->default(0)->comment('是否推荐首页[1 是 0 否]');
            $table->unsignedTinyInteger('post_status')->default(1)->comment('状态。可选值：0 隐藏 1 显示');
            $table->unsignedInteger('deleted_at')->default(0)->comment('删除时间[0表示没有删除]');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hb_cms_post` comment '内容表'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hb_cms_post` AUTO_INCREMENT=100001");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_cms_post');
    }
}
