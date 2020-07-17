<?php
declare (strict_types=1);

namespace App\Services\Repositories\Manage;


use App\Events\ManageAction;
use App\Services\Models\Manage\Manage;
use App\Services\Repositories\Manage\Interfaces\IManage;
use Illuminate\Support\Facades\Auth;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Helpers\StrHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

class ManageRepo extends BaseRepository implements IManage
{

    public function __construct(Manage $model)
    {
        parent::__construct($model);
    }

    /**
     * 管理员登录
     * @param string $username 登录名
     * @param string $password 密码
     * @param string $captcha  验证码
     * @param string $clientIp 客户端ip
     * @return array
     * @throws \Exception
     */
    public function doLogin(string $username, string $password, string $captcha, string $clientIp): array
    {
        $getCaptcha = cache('adminCaptcha');
        if (empty($captcha) || (strtolower($captcha) != strtolower($getCaptcha))) {
            return ResultHelper::returnFormat('验证码错误！', -1);
        }
        if (empty($username)) {
            return ResultHelper::returnFormat('用户名不能为空！', -1);
        }
        if (empty($password)) {
            return ResultHelper::returnFormat('密码不能为空！', -1);
        }
        $loginResult = Auth::guard('admin')->attempt(['username' => $username, 'password' => $password]);
        if ($loginResult) {
            $user = Auth::guard('admin')->user();
            if (intval($user['manage_status']) !== 1) {
                //被禁用用户，直接退出登录
                Auth::guard('admin')->logout();
                return ResultHelper::returnFormat('用户被禁用！', -1);
            }
            // 更新登录信息
            $data['last_login_ip'] = StrHelper::ip2long($clientIp);
            $data['last_login_time'] = time();
            $this->model->where('manage_id', $user->manage_id)->update($data);
            // 监听登录，并记录日志
            event(new ManageAction($user->manage_id, $user->username, request()->url(), '登录', [], $clientIp, request()->userAgent()));
            return ResultHelper::returnFormat('登录成功！', 200);
        } else {

            // 清除验证码
            cache(['adminCaptcha' => null], 60 * 10);

            return ResultHelper::returnFormat('用户名或密码错误！', -1);
        }
    }


}
