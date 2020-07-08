<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHbManageModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_manage_module', function (Blueprint $table) {
            $table->increments('module_id');
            $table->string('module_name',50)->default('')->comment('模块标题');
            $table->string('module',50)->default('')->comment('项目名');
            $table->string('controller',50)->default('')->comment('控制器名');
            $table->string('method',50)->default('')->comment('方法名');
            $table->unsignedInteger('pid')->default(0)->comment('上级模块id');
            $table->unsignedInteger('module_level')->default(0)->comment('深度等级');
            $table->string('module_route',128)->default('')->comment('路由名称（同一个项目中的路由不能一样）');
            $table->unsignedTinyInteger('is_menu')->default(0)->comment('是否菜单[1 是, 0 否]');
            $table->unsignedInteger('module_sort')->default(0)->comment('排序');
            $table->string('module_desc',512)->default('')->comment('模块描述');
            $table->string('module_icon_class',60)->default('')->comment('模块图标');
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        });
        //表注释
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `hb_manage_module` comment '后台权限模块'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_manage_module');
    }
}
