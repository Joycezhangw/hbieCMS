<?php


namespace App\Http\Controllers\Manage;


use App\Services\Repositories\System\Interfaces\ISysMpPages;
use Illuminate\Http\Request;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class MpPages extends ManageController
{
    /**
     * 列表
     * @param ISysMpPages $sysMpPagesRepo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ISysMpPages $sysMpPagesRepo)
    {
        $lists = $sysMpPagesRepo->all([], ['*'], 'page_sort', 'asc');
        $pages = $sysMpPagesRepo->parseDataRows($lists->toArray());
        return $this->view(compact('pages'));
    }

    /**
     * 创建
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return $this->view();
    }

    /**
     * 修改
     * @param int $id
     * @param ISysMpPages $sysMpPagesRepo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id, ISysMpPages $sysMpPagesRepo)
    {
        if (empty($id)) {
            abort(490, '编号错误');
        }
        if (intval($id) <= 0) {
            abort(490, '编号错误');
        }
        $info = $sysMpPagesRepo->getByPkId($id);
        if (!$info) {
            abort(490, '页面不存在');
        }
        $page = $sysMpPagesRepo->parseDataRow($info->toArray());
        return $this->view(compact('page'));
    }

    /**
     * 提交数据
     * @param Request $request
     * @param ISysMpPages $sysMpPagesRepo
     * @return array
     */
    public function store(Request $request, ISysMpPages $sysMpPagesRepo)
    {
        $params = $request->all();
        $params['is_show'] = isset($params['is_show']) ? 1 : 0;
        if ($sysMpPagesRepo->doCreate($params)) {
            return ResultHelper::returnFormat('创建成功', 200);
        }
        return ResultHelper::returnFormat('服务器繁忙，请稍后再试', -1);
    }

    /**
     * 更新数据
     * @param Request $request
     * @param int $id
     * @param ISysMpPages $sysMpPagesRepo
     * @return array
     */
    public function update(Request $request, int $id, ISysMpPages $sysMpPagesRepo)
    {
        $params = $request->all();
        $channel = $sysMpPagesRepo->getByPkId($id);
        if ($channel) {
            $params['is_show'] = isset($params['is_show']) ? 1 : 0;
            unset($params['_token']);
            unset($params['file']);
            $sysMpPagesRepo->doUpdateByPkId($params, $id);
            return ResultHelper::returnFormat('更新成功', 200);
        } else {
            return ResultHelper::returnFormat('该数据不存在，请稍后再试', -1);
        }
    }

    /**
     * 修改排序
     * @param Request $request
     * @param ISysMpPages $sysMpPagesRepo
     * @return array|mixed
     */
    public function modifySort(Request $request, ISysMpPages $sysMpPagesRepo)
    {
        $page_id = $request->post('page_id');
        $page_sort = $request->post('page_sort');
        if ($sysMpPagesRepo->doUpdateFieldByPkId((int)$page_id, 'page_sort', $page_sort)) {
            return ResultHelper::returnFormat('修改排序成功', 200);
        } else {
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }

    }
}
