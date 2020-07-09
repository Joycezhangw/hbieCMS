<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHbCmsPostDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_cms_post_data', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->comment('内容主键id');
            $table->longText('content')->comment('内容详情');

            $table->foreign('post_id')
                ->references('post_id')
                ->on('hb_cms_post')
                ->onDelete('cascade');

            $table->unique('post_id', 'uk_cms_post_id');

            $table->primary(['post_id'],
                'pk_cms_post_id');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hb_cms_post_data` comment '内容详情'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_cms_post_data');
    }
}
