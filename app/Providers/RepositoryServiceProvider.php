<?php


namespace App\Providers;

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
        //平台管理员
        if (class_exists(\App\Services\Repositories\Manage\Providers\RepositoryServiceProvider::class)) {
            $this->app->register(\App\Services\Repositories\Manage\Providers\RepositoryServiceProvider::class);
        }
        //系统
        if (class_exists(\App\Services\Repositories\System\Providers\RepositoryServiceProvider::class)) {
            $this->app->register(\App\Services\Repositories\System\Providers\RepositoryServiceProvider::class);
        }
        //会员
        if (class_exists(\App\Services\Repositories\UCenter\Providers\RepositoryServiceProvider::class)) {
            $this->app->register(\App\Services\Repositories\UCenter\Providers\RepositoryServiceProvider::class);
        }
        //内容
        if (class_exists(\App\Services\Repositories\CMS\Providers\RepositoryServiceProvider::class)) {
            $this->app->register(\App\Services\Repositories\CMS\Providers\RepositoryServiceProvider::class);
        }
    }
}
