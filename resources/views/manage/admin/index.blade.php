@extends('manage.layouts.layout')
@section('content')
    <div class="layui-collapse hb-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">操作提示<i class="layui-icon layui-colla-icon"></i></h2>
            <ul class="layui-colla-content layui-show">
                <li>用于后台管理员用户管理</li>
            </ul>
        </div>
    </div>
    <div class="hb-single-filter-box">
        <a href="{{route('manage.admin.create')}}" class="layui-btn hb-bg-color">添加管理员</a>
    </div>
    <div class="hb-screen layui-collapse">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">筛选<i class="layui-icon layui-colla-icon"></i></h2>
            <form class="layui-colla-content layui-form layui-show">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">管理员登录名：</label>
                        <div class="layui-input-inline">
                            <input type="text" id="search_text" name="search_text" placeholder="请输入管理员登录名"
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">创建时间：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" id="created_time" name="created_time" readonly
                                   placeholder="开始时间 - 结束时间" style="width: 350px!important">
                            <i class="hb-calendar"></i>
                        </div>
                    </div>
                </div>
                <div class="hb-form-row">
                    <button class="layui-btn hb-bg-color" lay-submit="" lay-filter="admin-list">筛选
                    </button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </form>
        </div>
    </div>
    <div class="admin-box">
        <table id="admin_list" lay-filter="admin_list" lay-size="lg"></table>
    </div>
    <script type="text/html" id="switchStatus">
        @{{# if(parseInt(d.is_super)<=0){ }}
        <input type="checkbox" name="manage_status" value="@{{d.manage_id}}" title="启用" lay-filter="lock"
               data-field_name="manage_status" @{{ d.manage_status== 1 ? 'checked' : '' }}>
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
                elem: '#admin_list',
                id: 'admin_list',
                cellMinWidth: 80,
                url: '{{route('manage.admin.index')}}',
                cols: [[
                    {field: 'username', title: '登录名'},
                    {field: 'realname', title: '真实姓名'},
                    {
                        field: 'is_super', title: '是否超级管理员', templet: function (data) {
                            var iconClass = parseInt(data.is_super) === 1 ? ' text-green layui-icon-ok ' : ' text-red layui-icon-close ';
                            return '<i class="layui-icon ' + iconClass + '"></i>'
                        }
                    },
                    {field: 'manage_status', title: '是否启用', templet: '#switchStatus'},
                    {field: 'last_login_time', title: '最后登录时间'},
                    {field: 'last_login_ip', title: '最后登录IP'},
                    {field: 'reg_ip', title: '创建IP'},
                    {field: 'reg_date_ago', title: '创建时间'},
                    {title: '操作', fixed: 'right', unresize: 'false', toolbar: '#operation'}
                ]]
            });
            /**
             * 监听工具栏操作
             */
            table.tool(function (obj) {
                var data = obj.data;
                if (obj.event === 'edit') {
                    window.open('{{route("manage.admin.edit")}}?id=' + data.manage_id);
                } else if (obj.event === 'reset') {
                    layer.confirm('你真的要将用户“' + data.username + '”密码重置为：123456', function (index) {
                        resetPwd(data)
                        layer.close(index);
                    });
                }
            });

            function resetPwd(data){
                $.ajax({
                    type: 'POST',
                    url: '{{route("manage.admin.resetPwd")}}',
                    data: {
                        _token: "{{csrf_token()}}",
                        id: data.manage_id,
                    },
                    dataType: 'JSON',
                    success: function (res) {
                        layer.msg(res.message);
                    }
                });
            }

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
                    url: '{{route("manage.admin.modifyFiled")}}',
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
             * 搜索功能
             */
            form.on('submit(admin-list)', function (data) {
                table._table.reload('admin_list', {
                    page: {
                        curr: 1
                    },
                    where: data.field
                });
                return false;
            });
        });
    </script>
@endsection
