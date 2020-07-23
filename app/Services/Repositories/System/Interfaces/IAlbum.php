<?php
declare (strict_types=1);

namespace App\Services\Repositories\System\Interfaces;


use JoyceZ\LaravelLib\Repositories\Interfaces\BaseInterface;

/**
 * 附件专辑
 * Interface IAlbum
 * @package App\Services\Repositories\System\Interfaces
 */
interface IAlbum extends BaseInterface
{

    /**
     * 获取树形专辑数据
     * @return array
     */
    public function getAlbumTree(): array;

}
