<?php
declare (strict_types=1);

namespace App\Services\Repositories\System;


use App\Services\Models\System\AlbumModel;
use App\Services\Repositories\System\Interfaces\IAlbum;
use JoyceZ\LaravelLib\Helpers\TreeHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

/**
 * 实现附件专辑
 * Class AlbumRepo
 * @package App\Services\Repositories\System
 */
class AlbumRepo extends BaseRepository implements IAlbum
{
    public function __construct(AlbumModel $model)
    {
        parent::__construct($model);
    }

    /**
     * 获取树形专辑数据
     * @return array
     */
    public function getAlbumTree(): array
    {
        $ret = $this->all([], ['album_id', 'album_name', 'pid'], 'album_sort');
        return TreeHelper::listToTree($ret->toArray(), 0, 'album_id');
    }


}
