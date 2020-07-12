<?php


namespace App\Providers;


use App\Services\Repositories\CMS\ArticleRepo;
use App\Services\Repositories\CMS\ChannelRepo;
use App\Services\Repositories\CMS\Interfaces\IArticle;
use App\Services\Repositories\CMS\Interfaces\IChannel;
use App\Services\Repositories\Manage\Interfaces\IManage;
use App\Services\Repositories\Manage\Interfaces\IManageModule;
use App\Services\Repositories\Manage\ManageModuleRepo;
use App\Services\Repositories\Manage\ManageRepo;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        //
    }

    public function register()
    {
        $this->app->bind(IManage::class,ManageRepo::class);//管理员
        $this->app->bind(IManageModule::class,ManageModuleRepo::class);//管理员权限模块
        $this->app->bind(IChannel::class,ChannelRepo::class);//内容栏目
        $this->app->bind(IArticle::class,ArticleRepo::class);//内容
    }
}
