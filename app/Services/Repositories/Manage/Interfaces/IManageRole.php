<?php
declare (strict_types=1);

namespace App\Services\Repositories\Manage\Interfaces;


use JoyceZ\LaravelLib\Repositories\Interfaces\BaseInterface;

/**
 * 后台管理员角色
 * Interface IManageRole
 * @package App\Services\Repositories\Manage\Interfaces
 */
interface IManageRole extends BaseInterface
{
    /**
     * 创建角色
     * @param array $params
     * @return bool
     */
    public function doCreateRole(array $params): bool;

    /**
     * 更新角色
     * @param int $roleId
     * @param array $params
     * @return bool
     */
    public function doUpdateRole(int $roleId, array $params): bool;

}
