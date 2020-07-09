<?php


namespace App\Services\Repositories\Manage;


use App\Services\Models\Manage\Manage;
use App\Services\Repositories\Manage\Interfaces\IManage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

class ManageRepo extends BaseRepository implements IManage
{

    public function __construct(Manage $model)
    {
        parent::__construct($model);
    }

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
            dd($user);
            if (intval($user['status']) !== 1) {
                return ResultHelper::returnFormat('用户被禁用！', -1);
            }
            // 更新登录信息
            $data['last_login_ip'] = $clientIp;
            $data['last_login_time'] = time();
            $this->model->where('manage_id', $user->manage_id)->update($data);

//            $result['id'] = $user->id;
//            $result['username'] = $user->username;
//            $result['nickname'] = $user->nickname;
//            $result['token'] = Str::random(950);
//
//            // 将认证信息写入缓存，这里用hack方法做后台api登录认证
//            cache([$result['token'] => $result], 60 * 60 * 3);

            return ResultHelper::returnFormat('登录成功！', 200);
        } else {

            // 清除验证码
            cache(['adminCaptcha' => null], 60 * 10);

            return ResultHelper::returnFormat('用户名或密码错误！', -1);
        }
    }


}
