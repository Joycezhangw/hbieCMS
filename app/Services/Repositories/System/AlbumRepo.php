<?php
declare (strict_types=1);

namespace App\Services\Repositories\System;


use App\Services\Models\System\Album;
use App\Services\Repositories\System\Interfaces\IAlbum;
use JoyceZ\LaravelLib\Helpers\TreeHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

class AlbumRepo extends BaseRepository implements IAlbum
{
    public function __construct(Album $model)
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
