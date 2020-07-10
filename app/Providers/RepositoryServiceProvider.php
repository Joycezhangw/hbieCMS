<?php


namespace App\Providers;


use App\Services\Repositories\CMS\ChannelRepo;
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
        $this->app->bind(IManage::class,ManageRepo::class);
        $this->app->bind(IManageModule::class,ManageModuleRepo::class);
        $this->app->bind(IChannel::class,ChannelRepo::class);
    }
}
