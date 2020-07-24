<?php
declare (strict_types=1);

namespace App\Services\Repositories\UCenter\Interfaces;


use JoyceZ\LaravelLib\Repositories\Interfaces\BaseInterface;

/**
 * 用户组接口
 * Interface IMemberGroup
 * @package App\Services\Repositories\UCenter\Interfaces
 */
interface IMemberGroup extends BaseInterface
{

    /**
     * 获取用户组
     * @return array
     */
    public function getAllList(): array;

}
