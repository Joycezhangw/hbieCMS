<?php
declare (strict_types=1);

namespace App\Services\Repositories\Manage;


use App\Services\Models\Manage\ManageModule;
use App\Services\Repositories\Manage\Interfaces\IManageModule;
use JoyceZ\LaravelLib\Helpers\TreeHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

class ManageModuleRepo extends BaseRepository implements IManageModule
{

    public function __construct(ManageModule $model)
    {
        parent::__construct($model);
    }

    /**
     * 获取该用户的权限菜单，和所有菜单
     * @param string $moduleName
     * @param array $member
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getModuleAuth(string $moduleName, array $member): array
    {
        if (intval($member['is_super']) === 1) {
            $menuList = $this->all(['module' => $moduleName, 'is_menu' => 1])->toArray();
            $authList = $this->all(['module' => $moduleName])->toArray();
        }
        $sideBar = TreeHelper::listToTreeMulti($menuList, 0, 'module_id');
        return compact('sideBar', 'authList');
    }

    /**
     * 根据路由名获取最新一条数据
     * @param string $route
     * @return array
     */
    public function getLastModuleByRoute(string $route): array
    {
        $ret = $this->model->where(['module_route' => $route])->orderBy('module_id', 'desc')->first();
        return $ret ? $ret->toArray() : [];
    }
}
