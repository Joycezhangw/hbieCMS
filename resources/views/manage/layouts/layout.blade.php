<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{$title_name}}</title>
    <link type="text/css" rel="stylesheet" href="/static/ac/lib/layui/css/layui.css"/>
    <link type="text/css" rel="stylesheet" href="/static/manage/css/common.css"/>
    <link type="text/css" rel="stylesheet" href="/static/css/simditor.css"/>
@yield('stylesheet')
<!-- [if lt IE 9]-->
    <script type="text/javascript" src="/static/ac/lib/html5shiv.min.js"></script>
    <script type="text/javascript" src="/static/ac/lib/respond.min.js"></script>
    <!-- [endif] -->
</head>
<body>
<div class="hb-logo">
    <span>马尾留学生创业园</span>
    <span>
		&nbsp;
	</span>
</div>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <!-- 一级菜单 -->
        <ul class="layui-nav layui-layout-left">
            @foreach($menu_list as $key=>$item)
                <li class="layui-nav-item @if($item['module_id']===$current_route_pid) layui-this @endif">
                    <a href="{{route($item['module_route'])}}">{{$item['module_name']}}</a>
                </li>
            @endforeach
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <div class="hb-img-box">
                        <img src="{{trim($admin_user['manage_avatar'])}}" alt="">
                    </div>
                    {{$admin_user['username']}} <span class="layui-nav-more"></span>
                </a>
                <dl class="layui-nav-child layui-anim layui-anim-upbit">
{{--                    <dd class="hb-reset-pass" onclick="resetPassword();">--}}
{{--                        <a href="javascript:;">修改密码</a>--}}
{{--                    </dd>--}}
                    <dd>
                        <a href="{{route('manage.logout')}}" class="login-out">退出登录</a>
                    </dd>
                </dl>
            </li>
        </ul>
    </div>
    @if($sidebar)
        @if(count($sidebar['children'])>0)
            <div class="layui-side">
                <div class="layui-side-scroll">
                    <span class="hb-side-title">{{$sidebar['module_name']}}</span>
                    <ul class="layui-nav layui-nav-tree">
                        @foreach($sidebar['children'] as $key=>$item)
                            <li class="layui-nav-item @if($item['module_id']===$parent_module_id) layui-nav-itemed @endif @if($item['module_route']===$current_route) layui-this @endif">
                                @if(count($item['children'])<=0)
                                    <a class="layui-menu-tips"
                                       href="{{route($item['module_route'])}}">{{$item['module_name']}}</a>
                                @else
                                    <a class="layui-menu-tips" href="javascript:;">{{$item['module_name']}}<span
                                            class="layui-nav-more"></span></a>
                                    <dl class="layui-nav-child">
                                        @foreach($item['children'] as $k=>$vo)
                                            <dd class=" @if($vo['module_route']===$current_route)layui-this @endif">
                                                <a href="{{route($vo['module_route'])}}">{{$vo['module_name']}}</a>
                                            </dd>
                                        @endforeach
                                    </dl>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    @endif
    <div class="layui-body  @if($sidebar) @if(count($sidebar['children'])<=0) child_no_exit @endif @endif">
        @if($sidebar)
            @if(count($sidebar['children'])>0)
                <div class="hb-crumbs">
            <span class="layui-breadcrumb" lay-separator=">" style="visibility: visible;">
                {!! $crumbs !!}
            </span>
                </div>
            @endif
        @endif
        <div class="hb-body-content @if($sidebar) @if(count($sidebar['children'])<=0) crumbs_no_exit @endif @endif">
            <div class="hb-body">
                @yield('content')
            </div>
            <!-- 版权信息 -->
            <div class="hb-footer">
                <div class="hb-footer-img">
                    <a href="#">技术支持 福建瀚邦信息工程有限公司</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/ac/lib/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/static/ac/lib/layui/layui.js"></script>
<script type="text/javascript" src="/static/ac/hbie.js"></script>
<script>
    layui.use(['layer', 'upload', 'element'], function() {});
    layui.use('element', function () {
        var element = layui.element;
        element.render('breadcrumb');
        element.init();
    })
</script>
@yield('javascript')
</body>
</html>
