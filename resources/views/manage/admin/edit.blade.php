@extends('manage.layouts.layout')
@section('content')
    <form class="layui-form hb-form">
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>用户名：</label>
            <div class="layui-input-block hb-len-long">
                <input name="username" type="text" placeholder="请输入内容标题" style="border:0"
                       class="layui-input" value="{{$admin->username}}" autocomplete="off" disabled>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>真实姓名：</label>
            <div class="layui-input-block hb-len-long">
                <input name="realname" type="text" placeholder="请输入真实姓名" lay-verify="realname" maxlength="128"
                       lay-verify="required" value="{{$admin->realname}}"
                       class="layui-input" autocomplete="off">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>设置角色：</label>
            <div class="layui-input-block" id="role_box">
                @foreach($rolesData as $role)
                    <input type="checkbox" name="roles[]" title="{{$role->role_title}}" value="{{$role->role_id}}" lay-skin="primary" @if(isset($roles[$role->role_id])) checked @endif>
                @endforeach
            </div>
            <div class="hb-word-aux">
                <p>角色对应用户得权限菜单</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否启用：</label>
            <div class="layui-input-block">
                <input type="checkbox" name="manage_status" lay-skin="switch" value="1" @if(intval($admin->manage_status)===1) checked @endif>
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
    <script type="text/javascript" src="/static/ac/lib/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="/static/ac/lib/tinymce/langs/zh_CN.js"></script>
    <script>
        var SAVE_URL = "{{route('manage.admin.update',$admin->manage_id)}}", INDEX_URL = "{{route('manage.admin.index')}}",
            CSRF_TOKEN = "{{csrf_token()}}";
        $(function () {
            layui.use(['form'], function () {
                var form = layui.form, repeat_flag = false;//防重复标识
                //自定义验证规则
                form.verify({
                    realname: function (value) {
                        if (parseInt(value) < 3) {
                            return '真实姓名至少得3个字符~'
                        }
                        if (!HBIE.string.isRealName(value)) {
                            return '真实姓名只能是中文或者英文'
                        }
                    }
                });
                form.on('submit(save)', function (data) {
                    if (repeat_flag) return false;
                    repeat_flag = true;
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
