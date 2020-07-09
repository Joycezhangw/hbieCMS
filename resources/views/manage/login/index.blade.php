<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>马尾留学生创业园</title>
    <link type="text/css" rel="stylesheet" href="/static/ext/layui/css/layui.css"/>
    <link type="text/css" rel="stylesheet" href="/static/manage/css/common.css"/>
    <link type="text/css" rel="stylesheet" href="/static/manage/css/login.css"/>
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="apply-header">
        <div class="apply-header-box">
            <div class="apply-header-title">
                <a href="javascript:;">
                    <span class="hb-text-color">马尾留学生创业园</span>
                </a>
            </div>
            <span class="phone">&nbsp;</span>
        </div>
    </div>
</div>
<div class="login-body">
    <div class="login-content">
        <h2>后台登录</h2>
        <div class="layui-form">
            <div class="login-input login-info">
                <div class="login-icon">
                    <img src="/static/manage/images/login/login_username.png" alt="">
                </div>
                <input type="text" name="username" lay-verify="userName" placeholder="请输入用户名" autocomplete="off"
                       class="layui-input">
            </div>
            <div class="login-input login-info">
                <div class="login-icon">
                    <img src="/static/manage/images/login/login_password.png" alt="">
                </div>
                <input type="password" name="password" lay-verify="password" placeholder="请输入密码" autocomplete="off"
                       class="layui-input">
            </div>
            <div class="login-input login-verification">
                <input type="text" name="captcha" lay-verify="verificationCode" placeholder="请输入验证码" autocomplete="off"
                       class="layui-input">
                <div class="login-verify-code-img">
                    <img id="verify_img" src="{{route('manage.captcha')}}" alt="captcha" onclick="verificationCode()">
                </div>
            </div>
            {{ csrf_field() }}
            <button id="login_btn" type="button" class="layui-btn hb-bg-color hb-login-btn" lay-submit=""
                    lay-filter="login">登录
            </button>
            </p>
        </div>
    </div>
    <div class="hb-login-bottom">
        <a class="hb-footer-img" href="#"></a>
        <p>技术支持<a href="javascript:;">&nbsp;&nbsp;福建瀚邦信息工程有限公司</a></p>
    </div>
</div>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/ext/layui/layui.js"></script>
<script type="text/javascript">
    var form, LOGIN_REPEAT_FLAG = false;
    layui.use('form', function () {
        form = layui.form;
        form.render();

        /* 登录 */
        form.on('submit(login)', function (data) {
            if (LOGIN_REPEAT_FLAG) return;
            LOGIN_REPEAT_FLAG = true;
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: '{{route("manage.login")}}',
                data: data.field,
                success: function (res) {
                    if (res.code === 200) {
                        layer.msg('登录成功', {anim: 5, time: 500}, function () {
                            window.location = '{{route("manage.index")}}';
                        });
                    } else {
                        layer.msg(res.message);
                        LOGIN_REPEAT_FLAG = false;
                        verificationCode();
                    }

                }
            })
        });

        /**
         * 表单验证
         */
        form.verify({
            userName: function (value) {
                if (!value.trim()) {
                    return "账号不能为空";
                }
            },
            password: function (value) {
                if (!value.trim()) {
                    return "密码不能为空";
                }
            },
            verificationCode: function (value) {
                if (!value.trim()) {
                    return "验证码不能为空";
                }
            }

        });
    });

    $("body").on("blur", ".login-content .login-input", function () {
        $(this).removeClass("login-input-select");
    });
    $("body").on("focus", ".login-content .login-input", function () {
        $(this).addClass("login-input-select");
    });

    $(document).keydown(function (event) {
        if (event.keyCode == 13) {
            $(".hb-login-btn").trigger("click");
        }
    });

    function verificationCode() {
        $("#verify_img").attr("src", "{{route('manage.captcha')}}" + "?" + Math.random());
    }
</script>
</body>
</html>
