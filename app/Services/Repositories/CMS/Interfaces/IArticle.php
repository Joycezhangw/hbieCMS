<?php
declare (strict_types=1);

namespace App\Services\Repositories\CMS\Interfaces;


use JoyceZ\LaravelLib\Repositories\Interfaces\BaseInterface;

interface IArticle extends BaseInterface
{

    /**
     * 根据条件获取内容列表
     * @param array $params
     * @return array
     */
    public function getArticlePageLists(array $params): array;

    /**
     * 添加内容
     * @param array $params 提交内容
     * @param array $adminUser 当前登录用户
     * @return array
     */
    public function doCreateArticle(array $params, array $adminUser): array;

    /**
     * 更新内容
     * @param int $articleId
     * @param array $params
     * @return array
     */
    public function doUpdateArticle(int $articleId, array $params): array;

}
