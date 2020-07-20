<?php
declare (strict_types=1);

namespace App\Services\Repositories\Manage\Interfaces;


use JoyceZ\LaravelLib\Repositories\Interfaces\BaseInterface;

interface IManageLog extends BaseInterface
{
    /**
     * 获取日志列表
     * @param array $params
     * @return array
     */
    public function getPageLists(array $params): array;
}
