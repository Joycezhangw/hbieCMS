@extends('manage.layouts.layout')
@section('content')
    <div class="layui-collapse hb-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">操作提示<i class="layui-icon layui-colla-icon"></i></h2>
            <ul class="layui-colla-content layui-show">
                <li>用于小程序首页幻灯片展示</li>
            </ul>
        </div>
    </div>
    <div class="hb-single-filter-box">
        <a href="{{route('manage.slide.create')}}" class="layui-btn hb-bg-color">添加幻灯片</a>
    </div>
    <div class="hb-screen layui-collapse">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">筛选<i class="layui-icon layui-colla-icon"></i></h2>
            <form class="layui-colla-content layui-form layui-show">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">幻灯片名称：</label>
                        <div class="layui-input-inline">
                            <input type="text" id="search_text" name="search_text" placeholder="请输入幻灯片名称"
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
                    <button class="layui-btn hb-bg-color" lay-submit="" lay-filter="slide-list">筛选
                    </button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </form>
        </div>
    </div>
    <div class="article-box">
        <table id="slide_list" lay-filter="slide_list" lay-size="lg"></table>
    </div>
    <script type="text/html" id="slide_pic">
        <div class="hb-img-box" id="article_img_@{{ d.slide_id }}">
            <img layer-src="" src="@{{ d.slide_pic_url }}" layer-index="0">
        </div>
    </script>
    <script type="text/html" id="slide_sort">
        <input type="number" class="layui-input hb-len-short" value="@{{d.slide_sort}}" onchange="editSort('@{{d.slide_id}}')" id="slide_sort@{{d.slide_id}}">
    </script>
    <!-- 工具栏操作 -->
    <script type="text/html" id="operation">
        <div class="hb-table-btn">
            <a href="javascript:;" class="layui-btn" lay-event="edit">修改</a>
        </div>
    </script>
@endsection
@section('javascript')
    <script>
        var table;
        layui.use(['form', 'laydate'], function () {
            var form = layui.form,
                laydate = layui.laydate;
            form.render();

            //日期时间范围渲染
            laydate.render({
                elem: '#created_time',
                type: 'datetime',
                range: '至'
            });
            table = new HBIE.Table({
                elem: '#slide_list',
                id: 'slide_list',
                url: '{{route('manage.slide.index')}}',
                cols: [[
                    {field: 'slide_name', width: '18%', title: '幻灯片名称'},
                    {field: 'slide_pic', width: '16%', title: '展示图', templet: '#slide_pic'},
                    {
                        field: 'is_show', width: '10%', title: '是否展示', templet: function (data) {
                            var str = '', status = parseInt(data.is_show);
                            if (status === 1) {
                                str = '是';
                            } else if (status === 0) {
                                str = '否';
                            }
                            return str;
                        }
                    },
                    {field: '', width: '20%', title: '排序', templet: '#slide_sort'},
                    {field: 'created_at_txt', width: '18%', title: '发布时间'},
                    {title: '操作', width: '15%', unresize: 'false', toolbar: '#operation'}
                ]]
            });
            /**
             * 监听工具栏操作
             */
            table.tool(function (obj) {
                var data = obj.data;
                switch (obj.event) {
                    case 'edit': //编辑
                        window.open('{{route("manage.slide.edit")}}?id=' + data.slide_id);
                        break;
                }
            });

            /**
             * 搜索功能
             */
            form.on('submit(slide-list)', function (data) {
                table._table.reload('slide_list', {
                    page: {
                        curr: 1
                    },
                    where: data.field
                });
                return false;
            });
        });
        // 监听单元格编辑
        function editSort(slide_id) {
            var sort = $("#slide_sort" + slide_id).val();

            console.log(sort)

            if (!new RegExp("^-?[1-9]\\d*$").test(sort)) {
                layer.msg("排序号只能是整数");
                return;
            }
            if (sort < 0) {
                layer.msg("排序号必须大于0");
                return;
            }
            $.ajax({
                type: 'POST',
                url: '{{route("manage.slide.modifySort")}}',
                data: {
                    _token:"{{csrf_token()}}",
                    slide_sort: sort,
                    slide_id: slide_id
                },
                dataType: 'JSON',
                success: function (res) {
                    layer.msg(res.message);
                }
            });
        }
    </script>
@endsection
