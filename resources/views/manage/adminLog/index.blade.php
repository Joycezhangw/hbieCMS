@extends('manage.layouts.layout')
@section('content')
    <div class="layui-collapse hb-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">操作提示<i class="layui-icon layui-colla-icon"></i></h2>
            <ul class="layui-colla-content layui-show">
                <li>管理员操作日志</li>
            </ul>
        </div>
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
                        <label class="layui-form-label">操作时间：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" id="created_time" name="created_time" readonly
                                   placeholder="开始时间 - 结束时间" style="width: 350px!important">
                            <i class="hb-calendar"></i>
                        </div>
                    </div>
                </div>
                <div class="hb-form-row">
                    <button class="layui-btn hb-bg-color" lay-submit="" lay-filter="log-list">筛选
                    </button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </form>
        </div>
    </div>
    <div class="log-box">
        <table id="log_list" lay-filter="log_list" lay-size="lg"></table>
    </div>
    <script type="text/html" id="is_home_rec">
        @{{ d.is_home_rec ===1 ?'是':'否' }}
    </script>
    <!-- 工具栏操作 -->
    <script type="text/html" id="operation">
        <div class="hb-table-btn">
            <a href="javascript:;" class="layui-btn" lay-event="delete">删除</a>
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
                elem: '#log_list',
                id: 'log_list',
                cellMinWidth: 80,
                url: '{{route('manage.adminLog.index')}}',
                cols: [[
                    {field: 'manage_username', title: '管理员'},
                    {field: 'log_title', title: '行为'},
                    {field: 'log_url', title: '操作页面'},
                    {field: 'log_ip', title: 'IP'},
                    {field: 'useragent', title: '请求头'},
                    {field: 'created_at', title: '发布时间'},
                    {title: '操作', fixed: 'right', unresize: 'false', toolbar: '#operation'}
                ]]
            });
            /**
             * 监听工具栏操作
             */
            table.tool(function (obj) {
                var data = obj.data;
                if (obj.event === 'delete') {
                    layer.confirm('真的要删除这条日志吗？', function (index) {
                        delLog(obj,data)
                        layer.close(index);
                    });
                }
            });

            function delLog(obj, data) {
                $.ajax({
                    type: 'POST',
                    url: '{{route("manage.adminLog.destroy")}}',
                    data: {
                        _token: "{{csrf_token()}}",
                        id: data.log_id,
                    },
                    dataType: 'JSON',
                    success: function (res) {
                        layer.msg(res.message);
                        if (res.code == 200) {
                            obj.del();
                        }
                    }
                });
            }

            /**
             * 搜索功能
             */
            form.on('submit(log-list)', function (data) {
                table._table.reload('log_list', {
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
