<?php


namespace App\Http\Controllers\Manage;


use App\Services\Repositories\UCenter\Interfaces\IMember;
use App\Services\Repositories\UCenter\Interfaces\IMemberGroup;
use App\Utility\Format;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Member extends ManageController
{

    public function index(Request $request, IMember $memberRepo, IMemberGroup $memberGroupRepo)
    {
        if ($request->ajax()) {
            if ($request->get('created_time')) {
                $date = explode('至', $request->get('created_time'));
                if (count($date) !== 2) {
                    return ResultHelper::returnFormat('success', 200, ['total' => 0, 'list' => []]);
                }
            }
            $ret = $memberRepo->getPageList($request->all());
            $list = Format::formatReturnDataByManyDim($ret['data']);
            return ResultHelper::returnFormat('success', 200, ['total' => $ret['total'], 'list' => $list]);
        }
        $groups = $memberGroupRepo->getAllList();
        return $this->view(compact('groups'));
    }

    /**
     * 修改用户状态
     * @param Request $request
     * @param IMember $memberRepo
     * @return array|mixed
     */
    public function modifyFiled(Request $request, IMember $memberRepo)
    {
        $id = intval($request->post('id'));
        if ($id <= 0) {
            return ResultHelper::returnFormat('缺少必要的参数', -1);
        }
        $fieldName = (string)$request->post('field_name');
        $fieldValue = $request->post('field_value');
        $ret = $memberRepo->doUpdateFieldByPkId($id, $fieldName, $fieldValue);
        if ($ret) {
            return ResultHelper::returnFormat('修改成功', 200);
        }
        return ResultHelper::returnFormat('服务器繁忙，请稍后再试', -1);
    }

    //重置管理员密码为123456
    public function resetPwd(Request $request, IMember $memberRepo)
    {
        $id = intval($request->post('id'));
        if ($id <= 0) {
            return ResultHelper::returnFormat('缺少必要的参数', -1);
        }
        $member = $memberRepo->getByPkId($id);
        if (!$member) {
            return ResultHelper::returnFormat('该用户不存在', -1);
        }
        $salt = Str::random(6);
        $member->password = bcrypt('123456' . $salt);
        $member->user_salt = $salt;
        if ($member->save()) {
            return ResultHelper::returnFormat('重置密码成功', 200);
        }
        return ResultHelper::returnFormat('服务器繁忙，请稍后再试', -1);
    }

    //修改用户页面
    public function edit(Request $request, IMember $memberRepo, IMemberGroup $memberGroupRepo)
    {
        $uid = $request->get('id');
        if (empty($uid)) {
            abort(490, '用户编号错误');
        }
        if (intval($uid) <= 0) {
            abort(490, '用户编号错误');
        }
        $member = $memberRepo->getByPkId(intval($uid));
        if (!$member) {
            abort(490, '用户不存在');
        }
        $groups = $memberGroupRepo->getAllList();
        return $this->view(compact('member', 'groups'));
    }

    //更新会员
    public function update(Request $request, int $id, IMember $memberRepo)
    {
        if (intval($id) <= 0) {
            abort(490, '用户编号错误');
        }
        $member = $memberRepo->getByPkId(intval($id));
        if (!$member) {
            abort(490, '用户不存在');
        }
        $member->group_id = $request->post('group_id') ? $request->post('group_id'):0;
        $member->realname = $request->realname;
        $member->user_state = $request->post('user_state') ? $request->post('user_state') : 0;
        if ($member->save()) {
            return ResultHelper::returnFormat('修改成功', 200);
        }
        return ResultHelper::returnFormat('服务器繁忙，请稍后再试', -1);
    }

}
