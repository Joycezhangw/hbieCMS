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
@yield('stylesheet')
<!-- [if lt IE 9]-->
    <script type="text/javascript" src="/static/ac/lib/html5shiv.min.js"></script>
    <script type="text/javascript" src="/static/ac/lib/respond.min.js"></script>
    <!-- [endif] -->
    <script>
        var MaxErrorReportLimit = 100;
        // 简单的将错误采集上报到 /api/logs/error
        window.onerror = function (message, source, lineno, colno, error) {
            // 同一个页面最多上报100次错误，防止某个循环错误页面一直打开，不断的报错
            if (MaxErrorReportLimit-- < 0) return;
            try {
                var msg = {
                    message: message,
                    source_module: 'manage',
                    source: source,
                    lineno: lineno,
                    colno: colno,
                    stack: error && error.stack,
                    href: window.location.href,
                };
                msg = JSON.stringify(msg);
                // 用于 macaca E2E 自动化测试
                // window.__macaca_latest_error = msg;
                var req = new XMLHttpRequest();
                req.open('post', '/api/logs/error', true);
                req.setRequestHeader('Content-Type', 'application/json');
                req.send(msg);

                // 此处还需 记录错误堆栈,根据当前登录的用户记录

            } catch (err) {
                console.log('report error', err);
            }
        };</script>
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="hb-logo">
            <div class="logo-box">
                CMS
            </div>
        </div>
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
                    <dd class="hb-reset-pass J-resetPassword">
                        <a href="javascript:;">修改密码</a>
                    </dd>
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
                                       href="{{$item['module_route']!=''?route($item['module_route']):'javascript:;'}}">{{$item['module_name']}}</a>
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
                    <div class="sidebar-switch open">
                        <span></span>
                        <i class="layui-icon layui-icon-shrink-right"></i>
                    </div>
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
                    <a href="#">技术支持 xxxxx</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 重置密码弹框html -->
<div class="layui-form" id="reset_pass" style="display: none;">
    <div class="layui-form-item">
        <label class="layui-form-label"><span class="required">*</span>原密码</label>
        <div class="layui-input-block">
            <input type="password" id="old_pass" name="old_pass" required class="layui-input hb-len-mid" maxlength="18"
                   autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"
                   onblur="this.setAttribute('readonly',true);">
            <span class="required"></span>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span class="required">*</span>新密码</label>
        <div class="layui-input-block">
            <input type="password" id="new_pass" name="new_pass" required class="layui-input hb-len-mid" maxlength="18"
                   autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"
                   onblur="this.setAttribute('readonly',true);">
            <span class="required"></span>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"><span class="required">*</span>确认新密码</label>
        <div class="layui-input-block">
            <input type="password" id="repeat_pass" name="repeat_pass" required class="layui-input hb-len-mid"
                   maxlength="18" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"
                   onblur="this.setAttribute('readonly',true);">
            <span class="required"></span>
        </div>
    </div>

    <div class="hb-form-row">
        <button class="layui-btn hb-bg-color J-repass">确定</button>
        <button class="layui-btn layui-btn-primary J-closePass">返回</button>
    </div>
</div>
<script type="text/javascript" src="/static/ac/lib/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/static/ac/lib/layui/layui.js"></script>
<script type="text/javascript" src="/static/ac/hbie.js"></script>
<script>
    layui.use(['layer', 'upload', 'element'], function () {
    });
    layui.use('element', function () {
        var element = layui.element;
        element.render('breadcrumb');
        element.init();
    });
    $(function () {
        var resetPwdIndex;

        function resetPassword() {
            resetPwdIndex = layer.open({
                type: 1,
                title: "重置密码",
                content: $('#reset_pass'),
                offset: 'auto',
                area: ['650px']
            });

            setTimeout(function () {
                $(".hb-reset-pass").removeClass('layui-this');
            }, 1000);
        }

        var repeat_flag = false;

        function repass() {
            var old_pass = $("#old_pass").val();
            var new_pass = $("#new_pass").val();
            var repeat_pass = $("#repeat_pass").val();

            if (old_pass == '') {
                $("#old_pass").focus();
                layer.msg("原密码不能为空");
                return;
            }

            if (new_pass == '') {
                $("#new_pass").focus();
                layer.msg("密码不能为空");
                return;
            } else if ($("#new_pass").val().length < 6) {
                $("#new_pass").focus();
                layer.msg("密码不能少于6位数");
                return;
            }
            if (repeat_pass == '') {
                $("#repeat_pass").focus();
                layer.msg("密码不能为空");
                return;
            } else if ($("#repeat_pass").val().length < 6) {
                $("#repeat_pass").focus();
                layer.msg("密码不能少于6位数");
                return;
            }
            if (new_pass != repeat_pass) {
                $("#repeat_pass").focus();
                layer.msg("两次密码输入不一样，请重新输入");
                return;
            }

            if (repeat_flag) return;
            repeat_flag = true;

            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: "{{route('manage.login.resetPwd')}}",
                data: {"old_pass": old_pass, "new_pass": new_pass, _token: "{{csrf_token()}}"},
                success: function (res) {
                    layer.msg(res.message);
                    repeat_flag = false;

                    if (res.code == 200) {
                        layer.close(resetPwdIndex);
                        location.href = "{{route('manage.logout')}}";
                        // location.reload();
                    }
                }
            });
        }

        function closePass() {
            layer.close(resetPwdIndex);
        }

        $('.J-resetPassword').on('click', function () {
            resetPassword();
        });
        $('.J-repass').on('click', function () {
            repass();
        });
        $('.J-closePass').on('click', function () {
            closePass();
        });


        function sidebarFun() {
            var sideThat = $('.layui-side'), sidebarSwitch = $('.sidebar-switch'), sideH = sideThat.height(),
                sideW = sideThat.width(), layuiBody = $('.layui-body');
            sidebarSwitch.css('top', sideH / 2);
            sidebarSwitch.click(function () {
                if ($(this).hasClass('open')) {
                    sideThat.animate({'width': '0px'}, 100);
                    layuiBody.animate({'left': '10px'}, 100);
                    sidebarSwitch.removeClass('open');
                    sidebarSwitch.children('i').attr('class', 'layui-icon layui-icon-spread-left');
                } else {
                    sideThat.animate({'width': sideW}, 100);
                    layuiBody.animate({'left': sideW}, 100);
                    sidebarSwitch.addClass('open');
                    sidebarSwitch.children('i').attr('class', 'layui-icon layui-icon-shrink-right');
                }
            });
        }
        sidebarFun();
    })
</script>
@yield('javascript')
</body>
</html>
