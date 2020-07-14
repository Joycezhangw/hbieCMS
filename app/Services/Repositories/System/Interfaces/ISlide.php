<?php
declare (strict_types=1);

namespace App\Services\Repositories\System\Interfaces;


use JoyceZ\LaravelLib\Repositories\Interfaces\BaseInterface;

/**
 * 幻灯片
 * Interface ISlide
 * @package App\Services\Repositories\System\Interfaces
 */
interface ISlide extends BaseInterface
{

    /**
     * 获取幻灯片分页列表
     * @param array $params
     * @return array
     */
    public function getSlidePageList(array $params): array;

}
