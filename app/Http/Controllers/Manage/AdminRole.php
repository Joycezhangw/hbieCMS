<?php
declare (strict_types=1);

namespace App\Http\Controllers\Manage;


use App\Services\Models\Manage\ManageRole;
use App\Services\Repositories\Manage\Interfaces\IManageModule;
use App\Services\Repositories\Manage\Interfaces\IManageRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Helpers\TreeHelper;

class AdminRole extends ManageController
{

    public function index(IManageRole $manageRoleRepo)
    {
        $roles = $manageRoleRepo->all();
        return $this->view(compact('roles'));
    }

    public function create(IManageModule $manageModuleRepo)
    {
        $modules = $manageModuleRepo->all([], ['module_id', 'module_name','pid','module_level']);
        foreach ($modules as $module){
            $module->checked=false;
        }
        $rules = TreeHelper::listToTreeKeyPk($modules->toArray(), 0, 'module_id');
        return $this->view(compact('rules'));
    }

    /**
     * 修改角色页面
     * @param int $id
     * @param IManageRole $manageRoleRepo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id, IManageRole $manageRoleRepo,IManageModule $manageModuleRepo)
    {
        if (empty($id)) {
            abort(490, '角色编号错误');
        }
        if (intval($id) <= 0) {
            abort(490, '角色编号错误');
        }
        $role = $manageRoleRepo->getByPkId(intval($id));
        $rules=[];
        foreach($role->rules as $rule){
            $rules[$rule->module_id]=$rule->toArray();
        }
        $modules = $manageModuleRepo->all([], ['module_id', 'module_name','pid','module_level']);
        foreach ($modules as $module){
            $module->checked= isset($rules[$module->module_id]) ? true: false;
        }
        $rules = TreeHelper::listToTreeKeyPk($modules->toArray(), 0, 'module_id');
        if (!$role) {
            abort(490, '角色不存在');
        }
        return $this->view(compact('role','rules'));
    }

    // 表单验证规则
    protected $rules = [
        'role_title' => 'required',
        "rules"    => "required|array|min:1",
    ];

    protected $ruleMessage = [
        'role_title.required' => '请输入角色名称',
        'rules.required' => '请选择权限',
        'rules.array' => '权限格式错误',
        'rules.min' => '至少要选择一个权限',
    ];

    /**
     * 添加角色
     * @param Request $request
     * @param IManageRole $manageRoleRepo
     * @return array|mixed
     */
    public function store(Request $request, IManageRole $manageRoleRepo)
    {
        $params = $request->all();
        // 进行验证
        $validator = Validator::make($request->all(), $this->rules, $this->ruleMessage);
        if ($validator->fails()) {
            return ResultHelper::returnFormat($validator->getMessageBag()->first(), -1);
        }
        if ($manageRoleRepo->doCreateRole($params)) {
            return ResultHelper::returnFormat('添加角色成功', 200);
        } else {
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }
    }

    /**
     * 更新角色
     * @param Request $request
     * @param int $id
     * @param IManageRole $manageRoleRepo
     * @return array|mixed
     */
    public function update(Request $request, int $id, IManageRole $manageRoleRepo)
    {
        $params = $request->all();
        // 进行验证
        $validator = Validator::make($request->all(), $this->rules, $this->ruleMessage);
        if ($validator->fails()) {
            return ResultHelper::returnFormat($validator->getMessageBag()->first(), -1);
        }
        if ($manageRoleRepo->doUpdateRole($id,$params)) {
            return ResultHelper::returnFormat('更新角色成功', 200);
        } else {
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }
    }

}
