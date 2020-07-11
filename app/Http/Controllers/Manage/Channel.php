<?php


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
        if ($channelRepo->doCreate($request->all())) {
            return ResultHelper::returnFormat('添加栏目成功', 200);
        } else {
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }
    }

    /**
     * 修改排序
     * @param Request $request
     * @param IChannel $channelRepo
     */
    public function modifySort(Request $request, IChannel $channelRepo)
    {
        $channelId=$request->post('channel_id');
        $channel_sort=$request->post('channel_sort');
        if($channelRepo->doUpdateFieldByPkId($channelId,'channel_sort',$channel_sort)){
            return ResultHelper::returnFormat('修改排序成功', 200);
        }else{
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }

    }
}
