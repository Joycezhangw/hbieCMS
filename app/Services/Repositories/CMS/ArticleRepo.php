<?php


namespace App\Services\Repositories\CMS;


use App\Services\Models\CMS\Post;
use App\Services\Repositories\CMS\Interfaces\IArticle;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

class ArticleRepo extends BaseRepository implements IArticle
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }
}
