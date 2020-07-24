<?php


namespace App\Http\Controllers\Manage;


use App\Services\Repositories\UCenter\Interfaces\IMemberGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JoyceZ\LaravelLib\Helpers\FiltersHelper;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class MemberGroup extends ManageController
{

    public function index(IMemberGroup $memberGroupRepo)
    {
        $groups = $memberGroupRepo->getAllList();
        return $this->view(compact('groups'));
    }

    public function create()
    {
        return $this->view();
    }

    /**
     * 修改角色页面
     * @param int $id
     * @param IMemberGroup $memberGroupRepo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id, IMemberGroup $memberGroupRepo)
    {
        if (empty($id)) {
            abort(490, '用户组编号错误');
        }
        if (intval($id) <= 0) {
            abort(490, '用户组编号错误');
        }
        $group = $memberGroupRepo->getByPkId(intval($id));
        if (!$group) {
            abort(490, '用户组不存在');
        }
        return $this->view(compact('group'));
    }

    // 表单验证规则
    protected $rules = [
        'group_title' => 'required',
    ];

    protected $ruleMessage = [
        'group_title.required' => '请输入用户组名称',
    ];


    public function store(Request $request, IMemberGroup $memberGroupRepo)
    {
        $params = $request->all();
        // 进行验证
        $validator = Validator::make($params, $this->rules, $this->ruleMessage);
        if ($validator->fails()) {
            return ResultHelper::returnFormat($validator->getMessageBag()->first(), -1);
        }
        if ($memberGroupRepo->doCreate([
            'group_title' => FiltersHelper::stringFilter($params['group_title']),
            'group_type' => $params['group_type'],
            'is_system' => isset($params['is_system']) ? 1 : 0,
            'group_remark' => FiltersHelper::stringFilter($params['group_remark']),
        ])) {
            return ResultHelper::returnFormat('添加用户组成功', 200);
        } else {
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }
    }

    /**
     * 更新角色
     * @param Request $request
     * @param int $id
     * @param IMemberGroup $manageRoleRepo
     * @return array|mixed
     */
    public function update(Request $request, int $id, IMemberGroup $memberGroupRepo)
    {
        $params = $request->all();
        // 进行验证
        $validator = Validator::make($request->all(), $this->rules, $this->ruleMessage);
        if ($validator->fails()) {
            return ResultHelper::returnFormat($validator->getMessageBag()->first(), -1);
        }
        $group = $memberGroupRepo->getByPkId($id);
        if (!$group) {
            return ResultHelper::returnFormat('用户组不存在', -1);
        }
        $group->group_title = FiltersHelper::stringFilter($params['group_title']);
        $group->group_type = $params['group_type'];
        $group->is_system = isset($params['is_system']) ? 1 : 0;
        $group->group_remark = FiltersHelper::stringFilter($params['group_remark']);
        if ($group->save()) {
            return ResultHelper::returnFormat('更新用户组成功', 200);
        } else {
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }
    }

}
