<?php

namespace App\Http\Middleware;

use App\Events\ManageAction;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
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
            $requestParams=$request->all();
            unset($requestParams['_token']);
            // 使用事件/监听器入库
            event(new ManageAction($admin->manage_id, $admin->username, $request->url(), '后台操作', $requestParams, $request->getClientIp(), $request->userAgent()));
        }
        return $next($request);
    }
}
