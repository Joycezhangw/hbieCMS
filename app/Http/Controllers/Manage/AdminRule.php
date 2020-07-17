<?php
declare (strict_types=1);

namespace App\Http\Controllers\Manage;


use App\Services\Repositories\Manage\Interfaces\IManageModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Helpers\TreeHelper;

class AdminRule extends ManageController
{

    public function index(IManageModule $manageModuleRepo)
    {
        $moduleList = $manageModuleRepo->all();
        $modules = TreeHelper::listToTree($moduleList->toArray(), 0, 'module_id');
        return $this->view(compact('modules'));
    }


    /**
     * 根据id修改指定字段值
     * @param Request $request
     * @param IManageModule $manageModuleRepo
     * @return array|mixed
     */
    public function modifyFiled(Request $request, IManageModule $manageModuleRepo)
    {
        $id = intval($request->post('id'));
        if ($id <= 0) {
            return ResultHelper::returnFormat('缺少必要的参数', -1);
        }
        $fieldName = (string)$request->post('field_name');
        $fieldValue = $request->post('field_value');
        $ret = $manageModuleRepo->doUpdateFieldByPkId($id, $fieldName, $fieldValue);
        if ($ret) {
            return ResultHelper::returnFormat('修改成功', 200);
        }
        return ResultHelper::returnFormat('服务器繁忙，请稍后再试', -1);
    }

    public function create(IManageModule $manageModuleRepo)
    {
        $moduleList = $manageModuleRepo->all([['is_menu', '=', 1], ['module_level', '<', 4]], ['module_id', 'module_name', 'pid', 'is_menu', 'module_level']);
        $modules = TreeHelper::listToTreeOne($moduleList->toArray(), 0, '', 'module_id');
        return $this->view(compact('modules'));
    }

    public function edit(int $id, IManageModule $manageModuleRepo)
    {
        if (empty($id)) {
            abort(490, '权限菜单编号错误');
        }
        if (intval($id) <= 0) {
            abort(490, '权限菜单编号错误');
        }
        $rule = $manageModuleRepo->getByPkId(intval($id));
        if (!$rule) {
            abort(490, '菜单不存在');
        }
        $moduleList = $manageModuleRepo->all([['is_menu', '=', 1], ['module_level', '<', 4]], ['module_id', 'module_name', 'pid', 'is_menu', 'module_level']);
        $modules = TreeHelper::listToTreeOne($moduleList->toArray(), 0, '', 'module_id');
        return $this->view(compact('rule', 'modules'));
    }

    // 表单验证规则
    protected $rules = [
        'module_name' => 'required',
        'module' => 'required',
        'controller' => 'required',
        'method' => 'required',
    ];

    protected $ruleMessage = [
        'module_name.required' => '请输入规则名称',
        'module.required' => '请输入项目模块名称',
        'controller.required' => '请输入控制器名称',
        'method.required' => '请输入方法名称',
    ];

    public function store(Request $request, IManageModule $manageModuleRepo)
    {


        // 进行验证
        $validator = Validator::make($request->all(), $this->rules, $this->ruleMessage);

        if ($validator->fails()) {
            return ResultHelper::returnFormat($validator->getMessageBag()->first(), -1);
        }
        return $manageModuleRepo->doCreateModule($request->all());
    }

    public function update(Request $request, int $id, IManageModule $manageModuleRepo)
    {
        // 进行验证
        $validator = Validator::make($request->all(),  $this->rules, $this->ruleMessage);

        if ($validator->fails()) {
            return ResultHelper::returnFormat($validator->getMessageBag()->first(), -1);
        }
        $module = $manageModuleRepo->getByPkId($id);
        if(!$module){
            return ResultHelper::returnFormat('该权限规则不存在', -1);
        }
        return $manageModuleRepo->doUpdateModule($id,$request->all());
    }

}
