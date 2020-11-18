<?php
declare (strict_types=1);

namespace App\Http\Controllers\Manage;


use App\Services\Repositories\CMS\Interfaces\IChannel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Helpers\TreeHelper;

class Channel extends ManageController
{
    public function index(IChannel $channelRepo)
    {
        $channelListRet = $channelRepo->all([],['*'],'channel_sort','asc');
        $channelList=$channelRepo->parseDataRows($channelListRet->toArray());
        $channels = TreeHelper::listToTree($channelList, 0, 'channel_id');
        return $this->view(compact('channels'));
    }

    public function create(IChannel $channelRepo)
    {
        $channels = $channelRepo->all(['pid'=> 0]);
        return $this->view(compact('channels'));
    }

    // 表单验证规则
    protected $rules = [
        'channel_name' => 'required',
    ];

    protected $ruleMessage = [
        'channel_name.required' => '请输入栏目名称',
    ];


    /**
     * 提交数据
     * @param Request $request
     * @param IChannel $channelRepo
     * @return array|mixed
     */
    public function store(Request $request, IChannel $channelRepo)
    {
        $params = $request->all();
        // 进行验证
        $validator = Validator::make($request->all(), $this->rules, $this->ruleMessage);
        if ($validator->fails()) {
            return ResultHelper::returnFormat($validator->getMessageBag()->first(), -1);
        }
        $params['is_show'] = isset($params['is_show']) ? 1 : 0;
        $params['is_allow_content'] = isset($params['is_allow_content']) ? 1 : 0;
        $params['is_notice'] = isset($params['is_notice']) ? 1 : 0;
        if ($channelRepo->doCreate($params)) {
            return ResultHelper::returnFormat('添加栏目成功', 200);
        } else {
            return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
        }
    }

    public function edit(int $id, IChannel $channelRepo)
    {
        if (empty($id)) {
            abort(490, '栏目编号错误');
        }
        if (intval($id) <= 0) {
            abort(490, '栏目编号错误');
        }
        $channelRet = $channelRepo->getByPkId($id);
        if (!$channelRet) {
            abort(490, '栏目不存在');
        }
        $channels = $channelRepo->all(['pid'=> 0]);
        $channel=$channelRepo->parseDataRow($channelRet->toArray());
        return $this->view(compact('channel','channels'));
    }

    public function update(Request $request, int $id, IChannel $channelRepo)
    {
        $params = $request->all();
        // 进行验证
        $validator = Validator::make($request->all(), $this->rules, $this->ruleMessage);
        if ($validator->fails()) {
            return ResultHelper::returnFormat($validator->getMessageBag()->first(), -1);
        }
        $channel = $channelRepo->getByPkId($id);
        if ($channel) {
            $params['is_show'] = isset($params['is_show']) ? 1 : 0;
            $params['is_allow_content'] = isset($params['is_allow_content']) ? 1 : 0;
            $params['is_notice'] = isset($params['is_notice']) ? 1 : 0;
            unset($params['_token']);
            unset($params['file']);
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
     * @return array|mixed
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

    /**
     * 快捷修改指定表字段值
     * @param Request $request
     * @param IChannel $channelRepo
     * @return array|mixed
     */
    public function modifyFiled(Request $request, IChannel $channelRepo)
    {
        $id = intval($request->post('id'));
        if ($id <= 0) {
            return ResultHelper::returnFormat('缺少必要的参数', -1);
        }
        $fieldName = (string)$request->post('field_name');
        $fieldValue = $request->post('field_value');
        $ret = $channelRepo->doUpdateFieldByPkId($id, $fieldName, $fieldValue);
        if ($ret) {
            return ResultHelper::returnFormat('修改成功', 200);
        }
        return ResultHelper::returnFormat('服务器繁忙，请稍后再试', -1);
    }
}
