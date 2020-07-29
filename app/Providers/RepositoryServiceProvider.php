<?php


namespace App\Providers;


use App\Services\Repositories\CMS\ArticleRepo;
use App\Services\Repositories\CMS\ChannelRepo;
use App\Services\Repositories\CMS\Interfaces\IArticle;
use App\Services\Repositories\CMS\Interfaces\IChannel;
use App\Services\Repositories\Manage\Interfaces\IManage;
use App\Services\Repositories\Manage\Interfaces\IManageLog;
use App\Services\Repositories\Manage\Interfaces\IManageModule;
use App\Services\Repositories\Manage\Interfaces\IManageRole;
use App\Services\Repositories\Manage\ManageLogRepo;
use App\Services\Repositories\Manage\ManageModuleRepo;
use App\Services\Repositories\Manage\ManageRepo;
use App\Services\Repositories\Manage\ManageRoleRepo;
use App\Services\Repositories\System\AlbumFileRepo;
use App\Services\Repositories\System\AlbumRepo;
use App\Services\Repositories\System\Interfaces\IAlbum;
use App\Services\Repositories\System\Interfaces\IAlbumFile;
use App\Services\Repositories\System\Interfaces\ISlide;
use App\Services\Repositories\System\Interfaces\IWebLogError;
use App\Services\Repositories\System\SlideRepo;
use App\Services\Repositories\System\WebLogErrorRepo;
use App\Services\Repositories\UCenter\Interfaces\IMember;
use App\Services\Repositories\UCenter\Interfaces\IMemberGroup;
use App\Services\Repositories\UCenter\MemberGroupRepo;
use App\Services\Repositories\UCenter\MemberRepo;
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
        $this->app->bind(IManage::class, ManageRepo::class);//管理员
        $this->app->bind(IManageModule::class, ManageModuleRepo::class);//管理员权限模块
        $this->app->bind(IChannel::class, ChannelRepo::class);//内容栏目
        $this->app->bind(IArticle::class, ArticleRepo::class);//内容
        $this->app->bind(IAlbumFile::class, AlbumFileRepo::class);//附件
        $this->app->bind(IAlbum::class, AlbumRepo::class);//附件专辑
        $this->app->bind(ISlide::class, SlideRepo::class);//幻灯片
        $this->app->bind(IManageLog::class, ManageLogRepo::class);//管理员日志
        $this->app->bind(IManageRole::class, ManageRoleRepo::class);//管理员角色
        $this->app->bind(IMember::class, MemberRepo::class);//用户管理
        $this->app->bind(IMemberGroup::class, MemberGroupRepo::class);//用户组管理
        $this->app->bind(IWebLogError::class, WebLogErrorRepo::class);//前端错误日志
    }
}
