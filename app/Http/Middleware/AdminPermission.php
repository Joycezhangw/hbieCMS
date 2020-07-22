<?php

namespace App\Http\Middleware;

use App\Services\Repositories\Manage\Interfaces\IManageModule;
use Closure;
use Illuminate\Support\Facades\Route;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class AdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //操作权限验证
        $manageModuleRepo=app(IManageModule::class);
        $permissions = $manageModuleRepo->getModuleAuth('manage',$request->admin);
        $hasPermission = false;
        foreach ($permissions['authList'] as $key => $value) {
            if ($value['module_route'] == Route::currentRouteName()) {
                $hasPermission = true;
            }
        }
        if(!$hasPermission) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(ResultHelper::returnFormat('无权限',-1));
            } else {
                return abort(403, '无权限');
            }
        }
        return $next($request);
    }
}
