@extends('manage.layouts.layout')
@section('content')
    <div class="layui-collapse hb-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">操作提示<i class="layui-icon layui-colla-icon"></i></h2>
            <ul class="layui-colla-content layui-show">
                <li>用于网站各栏目的内容发布管理</li>
            </ul>
        </div>
    </div>
    <div class="hb-single-filter-box">
        <a href="{{route('manage.article.create')}}" class="layui-btn hb-bg-color">添加内容</a>
    </div>
    <div class="hb-screen layui-collapse">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">筛选<i class="layui-icon layui-colla-icon"></i></h2>
            <form class="layui-colla-content layui-form layui-show">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">内容标题：</label>
                        <div class="layui-input-inline">
                            <input type="text" id="search_text" name="search_text" placeholder="请输入内容标题"
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">栏目：</label>
                        <div class="layui-input-inline">
                            <div class="layui-input-inline">
                                <select name="channel_id">
                                    <option value="">请选择栏目</option>
                                    @foreach($channels as $channel)
                                        <option value="{{$channel->channel_id}}">{{$channel->channel_name}}</option>
                                    @endforeach
                                </select>
                            </div>
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
                    <button class="layui-btn hb-bg-color" lay-submit="" lay-filter="article-list">筛选
                    </button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </form>
        </div>
    </div>
    <div class="article-box">
        <table id="article_list" lay-filter="article_list" lay-size="lg"></table>
    </div>
    <script type="text/html" id="is_home_rec">
        @{{ d.is_home_rec ===1 ?'是':'否' }}
    </script>
    <script type="text/html" id="post_pic">
        <div class="hb-img-box" id="article_img_@{{ d.post_id }}">
            <img layer-src="" src="@{{ d.post_pic_url }}" layer-index="0">
        </div>
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
                elem: '#article_list',
                id: 'article_list',
                url: '{{route('manage.article.index')}}',
                cols: [[
                    {field: 'post_id', width: '5%', title: '内容ID'},
                    {field: 'post_title', width: '18%', title: '内容标题'},
                    {field: 'post_source', width: '18%', title: '来源'},
                    {field: 'post_pic_url', width: '10%', title: '封面图', templet: '#post_pic'},
                    {
                        field: 'post_status', width: '6%', title: '是否显示', templet: function (data) {
                            var str = '', status = parseInt(data.post_status);
                            if (status === 1) {
                                str = '是';
                            } else if (status === 0) {
                                str = '否';
                            }
                            return str;
                        }
                    },
                    {field: 'is_home_rec', width: '10%', title: '是否推荐首页', templet: '#is_home_rec'},
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
                        location.href = '{{route("manage.article.edit")}}?id=' + data.post_id;
                        break;
                }
            });

            /**
             * 搜索功能
             */
            form.on('submit(article-list)', function (data) {
                table._table.reload('article_list', {
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
