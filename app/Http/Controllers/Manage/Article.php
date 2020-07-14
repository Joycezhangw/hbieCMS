<?php
declare (strict_types=1);

namespace App\Http\Controllers\Manage;


use App\Services\Repositories\CMS\Interfaces\IArticle;
use App\Services\Repositories\CMS\Interfaces\IChannel;
use Illuminate\Http\Request;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Article extends ManageController
{
    /**
     * 列表
     * @param Request $request
     * @param IChannel $channelRepo
     * @param IArticle $articleRepo
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index(Request $request, IChannel $channelRepo, IArticle $articleRepo)
    {
        if ($request->ajax()) {
            if ($request->get('created_time')) {
                $date = explode('至', $request->get('created_time'));
                if (count($date) !== 2) {
                    return ResultHelper::returnFormat('success', 200, ['total' => 0, 'list' => []]);
                }
            }
            $ret = $articleRepo->getArticlePageLists($request->all());
            $list = $this->formatReturnDataByManyDim($ret['data']);
            return ResultHelper::returnFormat('success', 200, ['total' => $ret['total'], 'list' => $list]);
        } else {
            $channels = $channelRepo->all();
            return $this->view(compact('channels'));
        }
    }

    /**
     * 创建页面
     * @param IChannel $channelRepo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(IChannel $channelRepo)
    {
        $channels = $channelRepo->all();
        return $this->view(compact('channels'));
    }

    /**
     * 提交数据
     * @param Request $request
     * @param IArticle $articleRepo
     * @return array
     */
    public function store(Request $request, IArticle $articleRepo)
    {
        $params = $request->all();
        $params['is_show'] = isset($params['is_show']) ? 1 : 0;
        $params['is_home_rec'] = isset($params['is_home_rec']) ? 1 : 0;
        return $articleRepo->doCreateArticle($params, $request->admin);
    }

    public function edit(Request $request, IArticle $articleRepo, IChannel $channelRepo)
    {
        $articleId = $request->get('id');
        if (empty($articleId)) {
            abort(490, '内容编号错误');
        }
        if (intval($articleId) <= 0) {
            abort(490, '内容编号错误');
        }
        $articleData = $articleRepo->getByPkId(intval($articleId));
        if (!$articleData) {
            abort(490, '内容不存在');
        }
        $channels = $channelRepo->all();
        $articleData->content;
        $article = $this->formatReturnDataByOneDim($articleData->toArray());
        return $this->view(compact('article', 'channels'));
    }

    public function update(Request $request, int $id, IArticle $articleRepo)
    {
        $article = $articleRepo->getByPkId($id);
        if (empty($article)) {
            return ResultHelper::returnFormat('该内容不存在', -1);
        }
        $params = $request->all();
        $params['is_show'] = isset($params['is_show']) ? 1 : 0;
        $params['is_home_rec'] = isset($params['is_home_rec']) ? 1 : 0;
        $ret = $articleRepo->doUpdateArticle($id, $params);
        return $ret;
    }

}
