@extends('manage.layouts.layout')
@section('content')
    <form class="layui-form hb-form">
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>用户名：</label>
            <div class="layui-input-block hb-len-long">
                <input name="username" type="text" placeholder="请输入内容标题" lay-verify="username" maxlength="16"
                       lay-verify="required"
                       class="layui-input" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>用户名格式必须为字母、数字、下划线，5-16位组成。</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>真实姓名：</label>
            <div class="layui-input-block hb-len-long">
                <input name="realname" type="text" placeholder="请输入真实姓名" lay-verify="realname" maxlength="128"
                       lay-verify="required"
                       class="layui-input" autocomplete="off">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>密码：</label>
            <div class="layui-input-block hb-len-long">
                <input name="password" type="text" placeholder="请输入密码" value="123456"
                       lay-verify="required"
                       class="layui-input" autocomplete="off">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>设置角色：</label>
            <div class="layui-input-block" id="role_box">
                @foreach($roles as $role)
                    <input type="checkbox" name="roles[]" title="{{$role->role_title}}" value="{{$role->role_id}}" lay-skin="primary">
                @endforeach
            </div>
            <div class="hb-word-aux">
                <p>角色对应用户得权限菜单</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否启用：</label>
            <div class="layui-input-block">
                <input type="checkbox" name="manage_status" lay-skin="switch" value="1" checked>
            </div>
            <div class="hb-word-aux">
                <p>用于控制用户是否能登录</p>
            </div>
        </div>
        <div class="hb-form-row">
            {{ csrf_field() }}
            <button class="layui-btn hb-bg-color" lay-submit="" lay-filter="save">保存</button>
            <button type="reset" class="layui-btn layui-btn-primary" onclick="back()">返回</button>
        </div>
    </form>
@endsection
@section('javascript')
    <!-- 引入 CDN Crypto.js 开始 AES加密 注意引入顺序 -->
    <script src="/static/ac/lib/crypto-js/core.js"></script>
    <script src="/static/ac/lib/crypto-js/enc-base64.js"></script>
    <script src="/static/ac/lib/crypto-js/md5.js"></script>
    <script src="/static/ac/lib/crypto-js/evpkdf.js"></script>
    <script src="/static/ac/lib/crypto-js/cipher-core.js"></script>
    <script src="/static/ac/lib/crypto-js/aes.js"></script>
    <script src="/static/ac/lib/crypto-js/pad-zeropadding.js"></script>
    <script src="/static/ac/lib/crypto-js/mode-ecb.js"></script>
    <script src="/static/ac/lib/crypto-js/enc-utf8.js"></script>
    <script src="/static/ac/lib/crypto-js/enc-hex.js"></script>
    <!-- 引入 CDN Crypto.js 结束 -->
    <script>
        var SAVE_URL = "{{route('manage.admin.store')}}", INDEX_URL = "{{route('manage.admin.index')}}";
        $(function () {
            layui.use(['form'], function () {
                var form = layui.form, repeat_flag = false;//防重复标识
                function checkPassword(str){
                    var reg1 = /[!@#$%^&*()_?<>{}~]{1}/;
                    var reg2 = /([a-zA-Z0-9!@#$%^&*()_?<>{}~]){8,18}/;
                    var reg3 = /[a-z]+/;
                    var reg4 = /[0-9]+/;
                    var reg5 = /[A-Z]+/;
                    if(reg1.test(str) && reg2.test(str) && reg3.test(str) && reg4.test(str) && reg5.test(str)){
                        return true;
                    }else if(!reg1.test(str)){
                        // alert("需包含一个特殊字符");
                        return false;
                    }else if(!reg2.test(str)){
                        // alert("长度在8-18位");
                        return false;
                    }else if(!reg3.test(str)){
                        // alert("需含有字母");
                        return false;
                    }else if(!reg4.test(str)){
                        // alert("需含有数字");
                        return false;
                    }else if(!reg5.test(str)){
                        // alert("需含有一个大写字母");
                        return false;
                    }
                }
                function encrypt(word, key, iv) {
                    return CryptoJS.AES.encrypt(word, CryptoJS.enc.Latin1.parse(key), {
                        iv: CryptoJS.enc.Latin1.parse(iv),
                        mode: CryptoJS.mode.CBC,
                        adding: CryptoJS.pad.ZeroPadding
                    }).toString();
                }
                //自定义验证规则
                form.verify({
                    username: function (value) {
                        if (value.length < 5) {
                            return '用户名至少得5个字符啊~';
                        }
                        if (!HBIE.string.isUserName(value)) {
                            return '用户名格式必须为字母、数字、下划线，5-16位组成。'
                        }
                    },
                    realname: function (value) {
                        if (value.length < 2) {
                            return '真实姓名至少得2个字符~'
                        }
                        if (!HBIE.string.isRealName(value)) {
                            return '真实姓名只能是中文或者英文'
                        }
                    },
                    password:function (value) {
                        if (value.length < 8 || value.length>18) {
                            return '密码长度在8-18位'
                        }
                        if(!checkPassword(value)){
                            return '长度在8-18位，包括至少1个大写字母，1个小写字母，1个数字，1个特殊字符'
                        }
                    }
                });
                form.on('submit(save)', function (data) {
                    if (repeat_flag) return false;
                    repeat_flag = true;
                    data.field.password = encrypt(data.field.password, '{{$key}}', '{{$iv}}');
                    $.ajax({
                        url: SAVE_URL,
                        data: data.field,
                        dataType: 'json',
                        type: 'post',
                        success: function (data) {
                            layer.msg(data.message);
                            if (data.code === 200) {
                                location.href = INDEX_URL;
                            } else {
                                repeat_flag = false;
                            }
                        }, error(err) {
                            repeat_flag = false;
                        }
                    });
                    return false;
                });
            })
        })
        function back() {
            location.href = INDEX_URL;
        }
    </script>
@endsection
