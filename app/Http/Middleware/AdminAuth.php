<?php

namespace App\Http\Middleware;

use App\Events\ManageAction;
use Closure;
use Illuminate\Support\Facades\Auth;
use JoyceZ\LaravelLib\Helpers\LaravelHelper;

class AdminAuth
{
    protected $routeAction = [
        'destroy' => '删除数据',
        'store' => '提交数据',
        'update' => '更新数据',
        'modifyFiled' => '快捷更新字段',
        'modifySort' => '更新排序',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //当 auth 中间件判定某个用户未认证，会返回一个 JSON 401 响应，或者，如果不是 Ajax 请求的话，将用户重定向到 login 命名路由（也就是登录页面）。
        if (Auth::guard('admin')->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('manage/login');
            }
        }
        $admin = Auth::guard('admin')->user();
        $admin->roles;
        $request->admin = $admin->toArray();
        //非 GET 请求，全部存到管理员日志当中
        if (!$request->isMethod('get')) {
            $requestParams = $request->all();
            $curAction = LaravelHelper::getTemplatePath();
            $logTitle = $curAction ? (isset($this->routeAction[$curAction['method']]) ? $this->routeAction[$curAction['method']] : '后台操作') : '后台操作';
            unset($requestParams['_token']);
            // 使用事件/监听器入库
            event(new ManageAction($admin->manage_id, $admin->username, $request->path(), $logTitle, $requestParams, $request->getClientIp(), $request->userAgent()));
        }
        return $next($request);
    }
}
