<?php
declare (strict_types=1);

namespace App\Http\Controllers\Manage;


use App\Events\ManageAction;
use App\Http\Controllers\Controller;
use App\Services\Repositories\Manage\Interfaces\IManage;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Login extends Controller
{
    /**
     * 登录页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('manage.login.index');
    }

    /**
     * 登录
     * @param Request $request
     * @param IManage $manageRepo
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request, IManage $manageRepo)
    {
        $username = $request->post('username');
        $password = $request->post('password');
        $captcha = $request->post('captcha');
        return response($manageRepo->doLogin($username, $password, $captcha, $request->ip()));
    }

    /**
     * 退出登录
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if ($user) {
            //监听退出登录，并记录日志
            event(new ManageAction($user->manage_id, $user->username, $request->url(), '退出登录', [], $request->getClientIp(), $request->userAgent()));
        }
        Auth::guard('admin')->logout();
        $request->session()->forget('admin');
        $request->session()->regenerate();
        return redirect('manage/login');
    }

    /**
     * 图形验证码
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function captcha()
    {
        $phrase = new PhraseBuilder();
        //设置验证码位数
        $code = Str::random(4);
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        //设置背景颜色
        $builder->setBackgroundColor(244, 252, 255);
        $builder->setMaxAngle(0);
        $builder->setMaxBehindLines(10);
        $builder->setMaxFrontLines(0);
        // 可以设置图片宽高及字体
        $builder->build($width = 110, $height = 38, $font = null);
        cache(['adminCaptcha' => $builder->getPhrase()], 60 * 10);
        return response($builder->output())->header('Content-type', 'image/jpeg');
    }

    /**
     * 重置密码
     * @param Request $request
     * @param IManage $manageRepo
     * @return array
     */
    public function resetPwd(Request $request, IManage $manageRepo)
    {
        $admin = $manageRepo->getByPkId($request->admin['manage_id']);
        if (!$admin) {
            return ResultHelper::returnFormat('该用户不存在', -1);
        }
        $admin->password = bcrypt($request->post('new_pass'));
        if ($admin->save()) {
            return ResultHelper::returnFormat('重置密码成功', 200);
        }
        return ResultHelper::returnFormat('服务器繁忙，请稍后再试', -1);
    }

}
