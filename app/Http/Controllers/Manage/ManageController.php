<?php


namespace App\Http\Controllers\Manage;


use App\Http\Controllers\Controller;
use App\Services\Repositories\Manage\Interfaces\IManageModule;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use JoyceZ\LaravelLib\Helpers\FiltersHelper;
use JoyceZ\LaravelLib\Helpers\LaravelHelper;
use JoyceZ\LaravelLib\Helpers\StrHelper;
use JoyceZ\LaravelLib\Helpers\TreeHelper;

class ManageController extends Controller
{
    private function __init()
    {
        $templatePath = LaravelHelper::getTemplatePath();
        $manageModuleRepo = app(IManageModule::class);
        $module = $templatePath['module'];
        $user = Auth::guard('admin')->user()->toArray();
        $user['manage_avatar'] = FiltersHelper::buildImageUri($user['manage_avatar']);
        //根据用户信息获取匹配的菜单数据，和全部权限数据。用户权限判断
        $moduleList = $manageModuleRepo->getModuleAuth($module, $user);
        $menu_list = [];
        foreach ($moduleList['sideBar'] as $key => $item) {
            $menu_list[$item['module_id']] = $item;
        }
        //获取当前页面路由别名
        $current_route = request()->route()->getName();
        //根据路由别名获取数据库最新一条数据。注意：上级沿用下级的路由值时，下级的数据信息要比上级数据信息大。否在会出现错误
        $route = $manageModuleRepo->getLastModuleByRoute($current_route);
        //根据当前路由，获取他全部上级路由数据
        $menuParent = TreeHelper::getParents($moduleList['authList'], $route['module_id'], 'module_id');

        //判断当前路由是否是菜单路由，如果是菜单路由，则选中当前路由，如果不是，则获取上级路由。且路由不能超过4级
        if (intval($route['is_menu']) === 1) {
            $currentRoute = $current_route;
        } else {
            $parent = TreeHelper::getParent($moduleList['authList'], $route['module_id'], 'module_id');
            $currentRoute = count($parent) > 0 ? $parent[0]['module_route'] : $current_route;
        }

        return [
            'admin_user' => $user,
            'current_route' => $currentRoute,//获取当前路由，用于定位菜单选中状态
            'current_route_pid' => isset($menuParent[0]) ? $menuParent[0]['module_id'] : 0,//获取最顶级父路由id，用户标识顶级菜单状态
            'title_name' => $route['module_name'] . '-' . '马尾留学生创业园',//网页title
            'menu_list' => $menu_list,//导航菜单
            'sidebar' => isset($menu_list[$menuParent[0]['module_id']]) ? $menu_list[$menuParent[0]['module_id']] : [],//侧边栏导航菜单
            'crumbs' => $this->getCrumbs($menuParent)//面包屑
        ];

    }

    /**
     * 返回视图
     *
     * 其匹配的路由规则必须是   模块>控制器>方法
     *
     * 例如  $router->get('index', 'Index@index')->name('manage.index.index');
     *
     * @param array $data
     * @param array $mergeData
     * @return \Illuminate\Contracts\View\Factory|View
     */
    protected function view(array $data = [], array $mergeData = [])
    {
        $initData = $this->__init();
        $data = array_merge($initData, $data);
        return view(Request()->route()->getName(), $data, $mergeData);
    }

    /**
     * 格式化面包屑
     * @param array $array
     * @return string
     */
    private function getCrumbs(array $array)
    {
        $str = '';
        $i = 0;
        if ($array) {
            foreach ($array as $item) {
                $i++;
                $route = $i === count($array) ? 'javascript:;' : (trim($item['module_route']) === '' ? 'javascript:;' : route($item['module_route']));
                $str .= '<a href="' . $route . '">' . $item['module_name'] . '</a><span lay-separator="">&gt;</span>';
            }
            //替换掉最后一个出现的标签
            return StrHelper::lreplace('<span lay-separator="">&gt;</span>', '', $str);
        }
        return $str;
    }

}
