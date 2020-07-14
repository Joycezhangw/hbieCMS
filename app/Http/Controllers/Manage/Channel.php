<?php
declare (strict_types=1);

namespace App\Http\Controllers\Manage;


use App\Services\Repositories\CMS\Interfaces\IChannel;
use Illuminate\Http\Request;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Channel extends ManageController
{
    public function index(IChannel $channelRepo)
    {
        $channels = $channelRepo->all();
        return $this->view(compact('channels'));
    }

    public function create()
    {
        return $this->view();
    }

    /**
     * 提交数据
     * @param Request $request
     * @param IChannel $channelRepo
     * @return array|mixed
     */
    public function store(Request $request, IChannel $channelRepo)
    {
        $params = $request->all();
        $params['is_show'] = isset($params['is_show']) ? 1 : 0;
        if ($channelRepo->doCreate($params)) {
            return ResultHelper::returnFormat('添加栏目成功', 200);
        } else {
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }
    }

    public function edit(int $id, IChannel $channelRepo)
    {
        $channel = $channelRepo->getByPkId($id);
        if ($channel) {
            return $this->view(compact('channel'));
        } else {
            return redirect()->route('manage.channel.index');
        }
    }

    public function update(Request $request, int $id, IChannel $channelRepo)
    {
        $channel = $channelRepo->getByPkId($id);
        if ($channel) {
            $params = $request->all();
            $params['is_show'] = isset($params['is_show']) ? 1 : 0;
            unset($params['_token']);
            $channelRepo->doUpdateByPkId($params, $id);
            return ResultHelper::returnFormat('更新栏目成功', 200);
        } else {
            return ResultHelper::returnFormat('该栏目不存在，请稍后再试', -1);
        }
    }

    /**
     * 修改排序
     * @param Request $request
     * @param IChannel $channelRepo
     */
    public function modifySort(Request $request, IChannel $channelRepo)
    {
        $channelId = $request->post('channel_id');
        $channel_sort = $request->post('channel_sort');
        if ($channelRepo->doUpdateFieldByPkId((int)$channelId, 'channel_sort', $channel_sort)) {
            return ResultHelper::returnFormat('修改排序成功', 200);
        } else {
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }

    }
}
