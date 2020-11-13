<?php
declare (strict_types=1);

namespace App\Services\Repositories\Manage\Interfaces;


use JoyceZ\LaravelLib\Repositories\Interfaces\BaseInterface;

/**
 * 管理员操作日志
 * Interface IManageLog
 * @package App\Services\Repositories\Manage\Interfaces
 */
interface IManageLog extends BaseInterface
{
    /**
     * 获取日志列表
     * @param array $params
     * @return array
     */
    public function getPageLists(array $params): array;
}
