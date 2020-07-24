<?php
declare (strict_types=1);

namespace App\Services\Repositories\UCenter\Interfaces;


use JoyceZ\LaravelLib\Repositories\Interfaces\BaseInterface;

/**
 * 会员管理仓库接口
 * Interface IMember
 * @package App\Services\Repositories\UCenter\Interfaces
 */
interface IMember extends BaseInterface
{
    /**
     * 获取用户列表
     * @param array $params
     * @return array
     */
    public function getPageList(array $params): array;

}
