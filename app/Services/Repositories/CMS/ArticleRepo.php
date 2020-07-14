<?php
declare (strict_types=1);

namespace App\Services\Repositories\CMS;


use App\Services\Models\CMS\Post;
use App\Services\Models\CMS\PostData;
use App\Services\Models\CMS\Tag;
use App\Services\Repositories\CMS\Interfaces\IArticle;
use JoyceZ\LaravelLib\Helpers\FiltersHelper;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

class ArticleRepo extends BaseRepository implements IArticle
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    /**
     * 获取文章内容列表
     * @param array $params
     * @return array
     */
    public function getArticlePageLists(array $params): array
    {
        $lists = $this->model->where(function ($query) use ($params) {
            if (isset($params['search_text']) && $params['search_text'] != '') {
                $query->where('post_title', 'like', '%' . $params['search_text'] . '%');
            }
            if (isset($params['created_time']) && $params['created_time'] != '') {
                $date = explode('至', $params['created_time']);
                $query->where('created_at', '>=', strtotime(trim($date[0])))->where('created_at', '<=', strtotime(trim($date[1])));
            }
            if (isset($params['channel_id']) && intval($params['channel_id']) > 0) {
                $query->where('channel_id', $params['channel_id']);
            }
        })->paginate(isset($params['page_size']) ? $params['page_size'] : config('student.paginate.page_size'));
        return $lists->toArray();
    }

    /**
     * 添加内容
     * @param array $params 提交内容
     * @param array $adminUser 当前登录用户
     * @return array
     */
    public function doCreateArticle(array $params, array $adminUser): array
    {
        $post = $this->doCreate([
            'post_title' => FiltersHelper::stringFilter($params['post_title']),
            'manage_id' => $adminUser['manage_id'],
            'manage_username' => $adminUser['username'],
            'channel_id' => intval($params['channel_id']),
            'post_tags' => $params['post_tags'] ? implode(',', $params['post_tags']) : '',
            'post_pic' => $params['post_pic'],
            'post_status' => $params['post_status'],
            'is_home_rec' => $params['is_home_rec'],
            'post_desc' => FiltersHelper::stringFilter($params['post_desc'])
        ]);
        if ($post) {
            $postId = $post->post_id;
            PostData::create(['post_id' => $postId, 'content' => FiltersHelper::stringFilter($params['content'])]);
            if (isset($params['post_tags'])) {
                if ($params['post_tags']) {
                    foreach ($params['post_tags'] as $tag) {
                        Tag::doSaveTag($tag, $postId);
                    }
                }
            }
            return ResultHelper::returnFormat('添加内容成功', 200);
        }
        return ResultHelper::returnFormat('网络繁忙，请稍后再试!', -1);
    }

    /**
     * 更新内容
     * @param int $articleId
     * @param array $params
     * @return array
     */
    public function doUpdateArticle(int $articleId, array $params): array
    {
        $post = $this->doUpdateByPkId([
            'post_title' => FiltersHelper::stringFilter($params['post_title']),
            'channel_id' => intval($params['channel_id']),
            'post_tags' => $params['post_tags'] ? implode(',', $params['post_tags']) : '',
            'post_pic' => $params['post_pic'],
            'post_status' => $params['post_status'],
            'is_home_rec' => $params['is_home_rec'],
            'post_desc' => FiltersHelper::stringFilter($params['post_desc'])
        ],$articleId);
        if ($post) {
            PostData::updateOrCreate(['post_id' => $articleId], ['content' => FiltersHelper::stringFilter($params['content'])]);
            if (isset($params['post_tags'])) {
                if ($params['post_tags']) {
                    foreach ($params['post_tags'] as $tag) {
                        Tag::doSaveTag($tag, $articleId);
                    }
                }
            }
            return ResultHelper::returnFormat('修改内容成功', 200);
        }
        return ResultHelper::returnFormat('网络繁忙，请稍后再试!', -1);
    }


}
