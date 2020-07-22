<?php
declare (strict_types=1);

namespace App\Services\Repositories\System;


use App\Services\Models\System\Album;
use App\Services\Repositories\System\Interfaces\IAlbum;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

class AlbumRepo extends BaseRepository implements IAlbum
{
    public function __construct(Album $model)
    {
        parent::__construct($model);
    }
}
