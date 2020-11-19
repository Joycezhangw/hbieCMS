<?php
declare (strict_types=1);

namespace App\Http\Controllers\Manage;


use App\Services\Repositories\Manage\Interfaces\IManageLog;
use Illuminate\Http\Request;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class AdminLog extends ManageController
{

    /**
     * 操作列表
     * @param Request $request
     * @param IManageLog $manageLogRepo
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index(Request $request, IManageLog $manageLogRepo)
    {
        if ($request->ajax()) {
            if ($request->get('created_time')) {
                $date = explode('至', $request->get('created_time'));
                if (count($date) !== 2) {
                    return ResultHelper::returnFormat('success', 200, ['total' => 0, 'list' => []]);
                }
            }
            $ret = $manageLogRepo->getPageLists($request->all());
            $list = $manageLogRepo->parseDataRows($ret['data']);
            return ResultHelper::returnFormat('success', 200, ['total' => $ret['total'], 'list' => $list]);
        } else {
            return $this->view();
        }
    }

    /**
     * 删除日志
     * @param Request $request
     * @param IManageLog $manageLog
     * @return array|mixed
     */
    public function destroy(Request $request, IManageLog $manageLog)
    {
        $id = intval($request->post('id'));
        if ($id <= 0) {
            return ResultHelper::returnFormat('缺少必要的参数', -1);
        }
        $log=$manageLog->getByPkId($id);
        if(!$log){
            return ResultHelper::returnFormat('该条日志不存在', -1);
        }
        $ret = $log->delete();
        if ($ret) {
            return ResultHelper::returnFormat('删除成功', 200);
        }
        return ResultHelper::returnFormat('服务器繁忙，请稍后再试', -1);
    }
}
