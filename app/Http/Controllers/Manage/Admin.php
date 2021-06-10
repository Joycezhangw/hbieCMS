<?php
declare (strict_types=1);

namespace App\Http\Controllers\Manage;


use App\Services\Repositories\Manage\Interfaces\IManage;
use App\Services\Repositories\Manage\Interfaces\IManageRole;
use App\Utility\CryptoJS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Admin extends ManageController
{
    //管理员列表
    public function index(Request $request, IManage $manageRepo)
    {
        if ($request->ajax()) {
            if ($request->get('created_time')) {
                $date = explode('至', $request->get('created_time'));
                if (count($date) !== 2) {
                    return ResultHelper::returnFormat('success', 200, ['total' => 0, 'list' => []]);
                }
            }
            $ret = $manageRepo->getManagePageLists($request->all());
            $list = $manageRepo->parseDataRows($ret['data']);
            return ResultHelper::returnFormat('success', 200, ['total' => $ret['total'], 'list' => $list]);
        } else {
            return $this->view();
        }
    }

    //创建管理员页面
    public function create(IManageRole $manageRoleRepo)
    {
        $roles = $manageRoleRepo->all(['is_default' => 0], ['role_id', 'role_title']);
        $iv =  CryptoJS::OPENSSL_IV;
        $key = CryptoJS::OPENSSL_KEY;
        return $this->view(compact('roles','iv','key'));
    }

    //修改管理员页面
    public function edit(Request $request, IManage $manageRepo, IManageRole $manageRoleRepo)
    {
        $adminId = $request->get('id');
        if (empty($adminId)) {
            abort(490, '管理员编号错误');
        }
        if (intval($adminId) <= 0) {
            abort(490, '管理员编号错误');
        }
        $admin = $manageRepo->getByPkId(intval($adminId));
        if (!$admin) {
            abort(490, '管理员不存在');
        }
        $roles=[];
        foreach($admin->roles as $role){
            $roles[$role->role_id]=$role->toArray();
        }
        $rolesData = $manageRoleRepo->all(['is_default' => 0], ['role_id', 'role_title']);
        return $this->view(compact('roles', 'admin','rolesData'));
    }


    public function store(Request $request, IManage $manageRepo)
    {
        // 表单验证规则
        $rules = [
            'username' => [
                'required', 'min:5', 'max:16', 'unique:hb_manage', 'regex:/^[a-zA-Z0-9_]{5,16}$/'
            ],
            'realname' => ['required', 'min:2'],
            "roles" => "required|array|min:1",
        ];
        $ruleMessage = [
            'username.required' => '请输入栏目名称',
            'username.min' => '用户名至少5个字符',
            'username.max' => '用户名最多16个字符',
            'username.unique' => '用户名已存在，请重新输入',
            'username.regex' => '用户名格式必须为字母、数字、下划线，5-16位组成。',
            'realname.required' => '请输入真实姓名',
            'realname.min' => '真实姓名至少2个字符',
//            'realname.not_regex' => '真实姓名只能由中英文组成',
            'roles.required' => '请选择角色',
            'roles.array' => '管理员角色格式错误',
            'roles.min' => '至少要选择一个角色',
        ];
        $validator = Validator::make($request->all(), $rules, $ruleMessage);
        if ($validator->fails()) {
            return ResultHelper::returnFormat($validator->getMessageBag()->first(), -1);
        }
        $password = CryptoJS::opensslDecrypt($request->password);
        $request->password=$password;
        if ($manageRepo->doCreateAdmin($request)) {
            return ResultHelper::returnFormat('创建用户成功', 200);
        } else {
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }
    }

    //更新用户
    public function update(Request $request, int $id, IManage $manageRepo)
    {
        $params = $request->all();
        // 表单验证规则
        $rules = [
            'realname' => ['required', 'min:2', 'not_regex:/^[a-zA-Z\u4e00-\u9fa5]+$/'],
            "roles" => "required|array|min:1",
        ];

        $ruleMessage = [
            'realname.required' => '请输入真实姓名',
            'realname.min' => '真实姓名至少2个字符',
            'realname.not_regex' => '真实姓名只能由中英文组成',
            'roles.required' => '请选择角色',
            'roles.array' => '管理员角色格式错误',
            'roles.min' => '至少要选择一个角色',
        ];
        // 进行验证
        $validator = Validator::make($request->all(), $rules, $ruleMessage);
        if ($validator->fails()) {
            return ResultHelper::returnFormat($validator->getMessageBag()->first(), -1);
        }
        if ($manageRepo->doUpdateAdmin($id, $params)) {
            return ResultHelper::returnFormat('更新用户成功', 200);
        } else {
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }
    }

    /**
     * 修改用户状态
     * @param Request $request
     * @param IManage $manageRepo
     * @return array|mixed
     */
    public function modifyFiled(Request $request, IManage $manageRepo)
    {
        $id = intval($request->post('id'));
        if ($id <= 0) {
            return ResultHelper::returnFormat('缺少必要的参数', -1);
        }
        $fieldName = (string)$request->post('field_name');
        $fieldValue = $request->post('field_value');
        $ret = $manageRepo->doUpdateFieldByPkId($id, $fieldName, $fieldValue);
        if ($ret) {
            return ResultHelper::returnFormat('修改成功', 200);
        }
        return ResultHelper::returnFormat('服务器繁忙，请稍后再试', -1);
    }


    //重置管理员密码为123456
    public function resetPwd(Request $request, IManage $manageRepo)
    {
        $id = intval($request->post('id'));
        if ($id <= 0) {
            return ResultHelper::returnFormat('缺少必要的参数', -1);
        }
        $admin = $manageRepo->getByPkId($id);
        if (!$admin) {
            return ResultHelper::returnFormat('该用户不存在', -1);
        }
        $admin->password = bcrypt('123456');
        if ($admin->save()) {
            return ResultHelper::returnFormat('重置密码成功', 200);
        }
        return ResultHelper::returnFormat('服务器繁忙，请稍后再试', -1);
    }
}
