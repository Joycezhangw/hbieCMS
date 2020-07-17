<?php
declare (strict_types=1);

namespace App\Services\Repositories\Manage\Interfaces;


use JoyceZ\LaravelLib\Repositories\Interfaces\BaseInterface;

/**
 * 后台全兴模块
 * Interface IManageModule
 * @package App\Services\Repositories\Manage\Interfaces
 */
interface IManageModule extends BaseInterface
{

    /**
     * 获取用户权限id
     * @param string $moduleName
     * @param array $member
     * @return array
     */
    public function getModuleAuth(string $moduleName, array $member): array;

    /**
     * 根据路由获取最新一条数据
     * @param string $route
     * @return array
     */
    public function getLastModuleByRoute(string $route): array;

    /**
     * 创建权限规则菜单
     * @param array $params
     * @return array
     */
    public function doCreateModule(array $params): array;

    /**
     * 根据id，更新权限规则
     * @param int $moduleId
     * @param array $params
     * @return array
     */
    public function doUpdateModule(int $moduleId, array $params): array;

}
