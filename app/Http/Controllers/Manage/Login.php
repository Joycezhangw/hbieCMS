<?php


namespace App\Http\Controllers\Manage;


use App\Http\Controllers\Controller;
use App\Services\Models\Manage\Manage;
use App\Services\Repositories\Manage\Interfaces\IManage;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Login extends Controller
{
    public function index()
    {
        return view('manage.login.index');
    }

    public function login(Request $request, IManage $manageRepo)
    {
        $username = $request->post('username');
        $password = $request->post('password');
        $captcha = $request->post('captcha');
        return response($manageRepo->doLogin($username, $password, $captcha, $request->ip()));
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

}
