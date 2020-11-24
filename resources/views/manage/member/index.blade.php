@extends('manage.layouts.layout')
@section('content')
    <div class="layui-collapse hb-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">操作提示<i class="layui-icon layui-colla-icon"></i></h2>
            <ul class="layui-colla-content layui-show">
                <li>用户由平台端进行统一管理，平台可以针对用户进行编辑，锁定等操作。</li>
            </ul>
        </div>
    </div>
    <div class="hb-screen layui-collapse">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">筛选<i class="layui-icon layui-colla-icon"></i></h2>
            <form class="layui-colla-content layui-form layui-show">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">账号</label>
                        <div class="layui-input-inline">
                            <select name="search_text_type">
                                <option value="username">用户名</option>
                                <option value="mobile">手机</option>
                                <option value="email">邮箱</option>
                            </select>
                        </div>
                        <div class="layui-input-inline">
                            <input type="text" name="search_text" placeholder="用户名/手机号/邮箱" autocomplete="off"
                                   class="layui-input ">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">状态</label>
                        <div class="layui-input-inline">
                            <select name="status">
                                <option value="">请选择</option>
                                <option value="1">正常</option>
                                <option value="0">已锁定</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">发布时间：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" id="created_time" name="created_time" readonly
                                   placeholder="开始时间 - 结束时间" style="width: 350px!important">
                            <i class="hb-calendar"></i>
                        </div>
                    </div>
                </div>
                <div class="hb-form-row">
                    <button class="layui-btn hb-bg-color" lay-submit="" lay-filter="search">筛选
                    </button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </form>
        </div>
    </div>
    <div class="article-box">
        <table id="member_list" lay-filter="member_list" lay-size="lg"></table>
    </div>
    <!-- 用户信息 -->
    <script type="text/html" id="userDetail">
        <div class='hb-table-tuwen-box'>
            <div class='hb-img-box'>
                <img layer-src src="@{{d.user_avatar_url}}" onerror="this.src = '/static/images/default-avatar.png' ">
            </div>
            <div class='hb-font-box'>
                <p class="layui-elip">@{{d.username}}</p>
            </div>
        </div>
    </script>
    <script type="text/html" id="switchStatus">
        @{{# if(parseInt(d.is_super)<=0){ }}
        <input type="checkbox" name="manage_status" value="@{{d.uid}}" title="启用" lay-filter="lock"
               data-field_name="user_state" @{{ d.user_state== 1 ? 'checked' : '' }}>
        @{{# }else{ }}
        <i class="layui-icon text-green layui-icon-ok "></i>
        @{{# } }}
    </script>
    <script type="text/html" id="operation">
        <div class="hb-table-btn">
            @{{# if(parseInt(d.is_super)<=0){ }}
            <a href="javascript:;" class="layui-btn" lay-event="edit">修改</a>
            <a href="javascript:;" class="layui-btn" lay-event="reset">重置密码</a>
            @{{# }else{ }}
            系统用户，不可操作
            @{{# } }}
        </div>
    </script>
@endsection
@section('javascript')
    <script>
        var GROUP_ARRAY =<?php echo json_encode($groups);?>;
        layui.use(['form', 'laydate'], function () {
            var table,
                form = layui.form,
                laydate = layui.laydate;
            form.render();

            //日期时间范围渲染
            laydate.render({
                elem: '#created_time',
                type: 'datetime',
                range: '至'
            });

            table = new HBIE.Table({
                elem: '#member_list',
                id: 'member_list',
                url: '{{route('manage.member.index')}}',
                cols: [[
                    {field: 'userDetail', title: '账户', templet: '#userDetail'},
                    {
                        field: 'group_id', title: '用户组', templet: function (data) {
                            return GROUP_ARRAY[data.group_id] ? GROUP_ARRAY[data.group_id].group_title : '-';
                        }
                    },
                    {
                        field: 'is_super', title: '是否超级管理员', templet: function (data) {
                            var iconClass = parseInt(data.is_super) === 1 ? ' text-green layui-icon-ok ' : ' text-red layui-icon-close ';
                            return '<i class="layui-icon ' + iconClass + '"></i>'
                        }
                    },
                    {field: 'user_status', title: '是否启用', templet: '#switchStatus'},
                    {field: 'last_login_time', title: '最后登录时间'},
                    {field: 'last_login_ip', title: '最后登录IP'},
                    {field: 'reg_ip', title: '注册IP'},
                    {field: 'reg_date_ago', title: '注册时间'},
                    {title: '操作', width: '15%', unresize: 'false', toolbar: '#operation'}
                ]]
            });
            /**
             * 搜索功能
             */
            form.on('submit(search)', function (data) {
                table._table.reload('member_list', {
                    page: {
                        curr: 1
                    },
                    where: data.field
                });
                return false;
            });
            //监听状态操作
            form.on('checkbox(lock)', function (obj) {
                var id = this.value, that = $(this);
                if (!new RegExp("^-?[1-9]\\d*$").test(id)) {
                    layer.msg("参数错误");
                    return;
                }
                if (id < 0) {
                    layer.msg("参数值错误");
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: '{{route("manage.member.modifyFiled")}}',
                    data: {
                        _token: "{{csrf_token()}}",
                        id: id,
                        field_name: that.data('field_name'),
                        field_value: obj.elem.checked ? 1 : 0
                    },
                    dataType: 'JSON',
                    success: function (res) {
                        layer.tips(res.message, obj.othis);
                    }
                });
            });

            /**
             * 监听工具栏操作
             */
            table.tool(function (obj) {
                var data = obj.data;
                if (obj.event === 'edit') {
                    window.open('{{route("manage.member.edit")}}?id=' + data.uid);
                } else if (obj.event === 'reset') {
                    layer.confirm('你真的要将用户“' + data.username + '”密码重置为：123456', function (index) {
                        resetPwd(data)
                        layer.close(index);
                    });
                }
            });

            function resetPwd(data) {
                $.ajax({
                    type: 'POST',
                    url: '{{route("manage.member.resetPwd")}}',
                    data: {
                        _token: "{{csrf_token()}}",
                        id: data.uid,
                    },
                    dataType: 'JSON',
                    success: function (res) {
                        layer.msg(res.message);
                    }
                });
            }

        });
    </script>
@endsection
