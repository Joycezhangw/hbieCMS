<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysAlbumFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_album_file', function (Blueprint $table) {
            $table->bigIncrements('file_id');
            $table->unsignedBigInteger('album_id')->index('idx_album_id')->default(0)->comment('专辑id');
            $table->string('file_name')->default('')->comment('图片名称');
            $table->string('file_path')->default('')->comment('图片物理路径');
            $table->unsignedDecimal('file_width')->default(0)->comment('图片宽度');
            $table->unsignedDecimal('file_height')->default(0)->comment('图片高度');
            $table->unsignedInteger('file_size')->default(0)->comment('文件长度');
            $table->string('file_ext', 10)->default('')->comment('文件扩展类型');
            $table->enum('file_type', ['image', 'video', 'doc'])->default('image')->index('idx_album_file_type')->comment('文件类型。可选值：image(图片)，video(视频)，doc(文档)');
            $table->string('mime_type', 128)->default('')->comment('文件mime类型');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `sys_album_file` comment '附件详细信息'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_album_file');
    }
}
