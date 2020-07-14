<?php


namespace App\Http\Controllers\Manage;


use App\Services\Repositories\System\Interfaces\ISlide;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use Illuminate\Http\Request;

class Slide extends ManageController
{

    public function index(Request $request, ISlide $slideRepo)
    {
        if ($request->ajax()) {
            if ($request->get('created_time')) {
                $date = explode('至', $request->get('created_time'));
                if (count($date) !== 2) {
                    return ResultHelper::returnFormat('success', 200, ['total' => 0, 'list' => []]);
                }
            }
            $ret = $slideRepo->getSlidePageList($request->all());
            $list = $this->formatReturnDataByManyDim($ret['data']);
            return ResultHelper::returnFormat('success', 200, ['total' => $ret['total'], 'list' => $list]);
        } else {
            return $this->view();
        }
    }

    public function create()
    {
        return $this->view();
    }

    public function store(Request $request, ISlide $slideRepo)
    {
        $params = $request->all();
        $params['is_show'] = isset($params['is_show']) ? 1 : 0;
        if ($slideRepo->doCreate($params)) {
            return ResultHelper::returnFormat('添加幻灯片成功', 200);
        } else {
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }
    }

    public function edit(Request $request, ISlide $slideRepo)
    {
        $slideId = $request->get('id');
        if (empty($slideId)) {
            abort(490, '幻灯片编号错误');
        }
        if (intval($slideId) <= 0) {
            abort(490, '幻灯片编号错误');
        }
        $slideData = $slideRepo->getByPkId(intval($slideId));
        if (!$slideData) {
            abort(490, '内容不存在');
        }
        $slide = $this->formatReturnDataByOneDim($slideData->toArray());
        return $this->view(compact('slide'));
    }

    public function update(Request $request, int $id, ISlide $slideRepo)
    {
        $slide = $slideRepo->getByPkId($id);
        if ($slide) {
            $params = $request->all();
            $params['is_show'] = isset($params['is_show']) ? 1 : 0;
            unset($params['_token']);
            unset($params['file']);
            $slideRepo->doUpdateByPkId($params, $id);
            return ResultHelper::returnFormat('更新幻灯片成功', 200);
        } else {
            return ResultHelper::returnFormat('该幻灯片不存在，请稍后再试', -1);
        }
    }

    /**
     * 修改排序
     * @param Request $request
     * @param ISlide $slideRepo
     * @return array|mixed
     */
    public function modifySort(Request $request, ISlide $slideRepo)
    {
        $slideId = intval($request->post('slide_id'));
        $slide_sort = intval($request->post('slide_sort'));
        if ($slideRepo->doUpdateFieldByPkId($slideId, 'slide_sort', $slide_sort)) {
            return ResultHelper::returnFormat('修改排序成功', 200);
        } else {
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }

    }

}
