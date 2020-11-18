<?php
declare (strict_types=1);

namespace App\Services\Repositories\CMS;


use App\Services\Models\CMS\ChannelModel;
use App\Services\Models\CMS\PostModel;
use App\Services\Models\CMS\PostDataModel;
use App\Services\Models\CMS\TagModel;
use App\Services\Repositories\CMS\Interfaces\IArticle;
use Illuminate\Support\Facades\Storage;
use JoyceZ\LaravelLib\Helpers\DateHelper;
use JoyceZ\LaravelLib\Helpers\FiltersHelper;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

/**
 * 实现文章内容接口
 * Class ArticleRepo
 * @package App\Services\Repositories\CMS
 */
class ArticleRepo extends BaseRepository implements IArticle
{
    public function __construct(PostModel $model)
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
        })
            ->select([
                'post_id',
                'post_title',
                'post_source',
                'post_pic',
                'post_status',
                'is_hot',
                'is_home_rec',
                'created_at',
            ])
            ->paginate(isset($params['page_size']) ? $params['page_size'] : config('student.paginate.page_size'));
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
            'post_source' => FiltersHelper::stringFilter($params['post_source']),
            'channel_id' => intval($params['channel_id']),
            'post_tags' => isset($params['post_tags']) ? implode(',', $params['post_tags']) : '',
            'post_pic' => $params['post_pic'] ? $params['post_pic'] : '',
            'post_video' => $params['post_video'] ? $params['post_video'] : '',
            'post_status' => $params['post_status'],
            'is_home_rec' => $params['is_home_rec'],
            'is_hot' => $params['is_hot'],
            'post_desc' => FiltersHelper::stringFilter($params['post_desc'])
        ]);
        if ($post) {
            $postId = $post->post_id;
            PostDataModel::create(['post_id' => $postId, 'content' => FiltersHelper::stringFilter($params['content'])]);
            if (isset($params['post_tags'])) {
                if ($params['post_tags']) {
                    foreach ($params['post_tags'] as $tag) {
                        TagModel::doSaveTag($tag, $postId);
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
            'post_source' => FiltersHelper::stringFilter($params['post_source']),
            'channel_id' => intval($params['channel_id']),
            'post_tags' => isset($params['post_tags']) ? implode(',', $params['post_tags']) : '',
            'post_pic' => $params['post_pic'] ? $params['post_pic'] : '',
            'post_video' => $params['post_video'] ? $params['post_video'] : '',
            'post_status' => $params['post_status'],
            'is_home_rec' => $params['is_home_rec'],
            'is_hot' => $params['is_hot'],
            'post_desc' => FiltersHelper::stringFilter($params['post_desc'])
        ], $articleId);
        if ($post) {
            PostDataModel::updateOrCreate(['post_id' => $articleId], ['content' => FiltersHelper::stringFilter($params['content'])]);
            if (isset($params['post_tags'])) {
                if ($params['post_tags']) {
                    foreach ($params['post_tags'] as $tag) {
                        TagModel::doSaveTag($tag, $articleId);
                    }
                }
            }
            return ResultHelper::returnFormat('修改内容成功', 200);
        }
        return ResultHelper::returnFormat('网络繁忙，请稍后再试!', -1);
    }

    /**
     * 获取小程序端首页数据集合
     * @return array
     */
    public function getHomeListData(): array
    {
        $channels = ChannelModel::where('is_show', 1)->orderBy('channel_sort', 'asc')->get(['channel_id', 'channel_name', 'channel_short_name']);
        if (!$channels) {
            return [];
        }
        $channelIds = [];
        foreach ($channels as $channel) {
            $channelIds[] = $channel->channel_id;
        }
        $posts = $this->model->whereIn('channel_id', $channelIds)
            ->where(['is_home_rec' => 1, 'post_status' => 1])
            ->orderBy('created_at', 'desc')
            ->get(['post_id', 'post_title', 'channel_id', 'manage_username', 'author_username', 'is_hot', 'post_source', 'post_tags', 'post_pic', 'post_desc', 'post_like', 'post_dislike', 'post_comment', 'post_view', 'post_fav', 'created_at']);
        $articles = [];
        foreach ($posts as $post) {
            $articles[$post->channel_id][] = $this->parseDataRow($post->toArray());
        }

        foreach ($channels as $channel) {
            $channel->articles = isset($articles[$channel->channel_id]) ? $articles[$channel->channel_id] : [];
        }
        return $channels->toArray();
    }

    public function parseDataRow(array $row): array
    {
        if (isset($row['post_pic'])) {
            $row['post_pic_url'] = !empty($row['post_pic']) ? asset(Storage::url($row['post_pic'])) : '';
        }
        if (isset($row['post_video'])) {
            $row['post_video_url'] = !empty($row['post_video']) ? asset(Storage::url($row['post_video'])) : '';
        }
        if (isset($row['created_at'])) {
            $row['created_at_txt'] = DateHelper::formatParseTime((int)$row['created_at']);
            $row['created_at_ago'] = DateHelper::formatDateLongAgo((int)$row['created_at']);
        }
        if (isset($row['post_tags'])) {
            $row['post_tags_arr'] = $row['post_tags'] ? explode(',', $row['post_tags']) : [];
        }
        return $row;
    }


}
