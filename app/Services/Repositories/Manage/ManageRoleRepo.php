<?php
declare (strict_types=1);

namespace App\Services\Repositories\Manage;


use App\Services\Models\Manage\ManageRole;
use App\Services\Repositories\Manage\Interfaces\IManageRole;
use JoyceZ\LaravelLib\Helpers\FiltersHelper;
use JoyceZ\LaravelLib\Helpers\StrHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

/**
 * 后台管理员角色接口实现
 * Class ManageRoleRepo
 * @package App\Services\Repositories\Manage
 */
class ManageRoleRepo extends BaseRepository implements IManageRole
{
    public function __construct(ManageRole $model)
    {
        parent::__construct($model);
    }

    /**
     * 创建角色
     * @param array $params
     * @return bool
     */
    public function doCreateRole(array $params): bool
    {
        $role = $this->doCreate([
            'role_title' => FiltersHelper::stringFilter($params['role_title']),
            'role_desc' => FiltersHelper::stringFilter($params['role_desc'])
        ]);
        if ($role) {
            $role->rules()->sync(array_filter(array_unique($params['rules'])));
            return true;
        }
        return false;
    }


    /**
     * 根据角色id，更新角色信息以及关联权限规则
     * @param int $roleId
     * @param array $params
     * @return bool
     */
    public function doUpdateRole(int $roleId, array $params): bool
    {
        $role = $this->getByPkId($roleId);
        if (!$role) {
            return false;
        }
        $ret = $this->doUpdateByPkId([
            'role_title' => FiltersHelper::stringFilter($params['role_title']),
            'role_desc' => FiltersHelper::stringFilter($params['role_desc'])
        ], $roleId);
        if ($ret) {
            //同步权限规则
//            $this->model->where('role_id', $roleId)->first()->syncRules(array_filter(array_unique($params['rules'])));
            $role->rules()->sync(array_filter(array_unique($params['rules'])));
            return true;
        }
        return false;
    }


}
