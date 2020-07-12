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
                        <label class="layui-form-label">内容标题：</label>
                        <div class="layui-input-inline">
                            <div class="layui-input-inline">
                                <select name="quiz">
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
                    <button class="layui-btn hb-bg-color" lay-submit="" lay-filter="search_website">筛选</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </form>
        </div>
    </div>
    <div class="cms-channel">

    </div>
@endsection
@section('javascript')
    <script>
        layui.use(['form', 'laydate'], function () {
            var table, table_website,
                form = layui.form,
                laydate = layui.laydate;
            form.render();

            //日期时间范围渲染
            laydate.render({
                elem: '#created_time',
                type: 'datetime',
                range: true
            });

            {{--/**--}}
            {{-- * 渲染表格--}}
            {{-- */--}}
            {{--table = new Table({--}}
            {{--    elem: '#shop_list',--}}
            {{--    url: ns.url("admin/shop/lists"),--}}
            {{--    cols: [--}}
            {{--        [{--}}
            {{--            field: 'site_name',--}}
            {{--            title: '店铺名称',--}}
            {{--            width: '12%',--}}
            {{--            unresize: 'false',--}}
            {{--            // templet: '<div><div class="layui-elip">店铺名称：{{d.site_name}}<div class="layui-elip">卖家账号：{{d.username}}</div>'--}}
            {{--        }, {--}}
            {{--            field: 'username',--}}
            {{--            title: '商家账号',--}}
            {{--            width: '8%',--}}
            {{--            unresize: 'false'--}}
            {{--        }, {--}}
            {{--            field: 'group_name',--}}
            {{--            title: '开店套餐',--}}
            {{--            width: '10%',--}}
            {{--            unresize: 'false'--}}
            {{--        }, {--}}
            {{--            field: 'category_name',--}}
            {{--            title: '主营行业',--}}
            {{--            width: '8%',--}}
            {{--            unresize: 'false'--}}
            {{--        }, {--}}
            {{--            field: 'is_own',--}}
            {{--            title: '是否自营',--}}
            {{--            width: '8%',--}}
            {{--            unresize: 'false',--}}
            {{--            templet: '#is_own'--}}
            {{--        }, {--}}
            {{--            field: 'cert_id',--}}
            {{--            title: '店铺认证',--}}
            {{--            width: '8%',--}}
            {{--            unresize: 'false',--}}
            {{--            templet: function(data) {--}}
            {{--                return data.cert_id == 0 ? '<span style="color: red">未认证</span>' : '<span style="color: green">已认证</span>';--}}
            {{--            }--}}
            {{--        }, {--}}
            {{--            field: 'shop_status',--}}
            {{--            title: '店铺状态',--}}
            {{--            width: '8%',--}}
            {{--            templet: '#status',--}}
            {{--            unresize: 'false'--}}
            {{--        }, {--}}
            {{--            field: 'create_time',--}}
            {{--            title: '入驻时间',--}}
            {{--            width: '12%',--}}
            {{--            unresize: 'false',--}}
            {{--            templet: function(data) {--}}
            {{--                return ns.time_to_date(data.create_time);--}}
            {{--            }--}}
            {{--        }, {--}}
            {{--            field: 'expire_time',--}}
            {{--            title: '到期时间',--}}
            {{--            width: '12%',--}}
            {{--            unresize: 'false',--}}
            {{--            templet: function(data) {--}}
            {{--                return ns.time_to_date(data.expire_time);--}}
            {{--            }--}}
            {{--        }, {--}}
            {{--            title: '操作',--}}
            {{--            width: '12%',--}}
            {{--            toolbar: '#operation',--}}
            {{--            unresize: 'false'--}}
            {{--        }]--}}
            {{--    ]--}}
            {{--});--}}

            {{--// 有城市分站--}}
            {{--table_website = new Table({--}}
            {{--    elem: '#shop_website_list',--}}
            {{--    url: ns.url("city://admin/shop/lists"),--}}
            {{--    cols: [--}}
            {{--        [{--}}
            {{--            field: 'site_name',--}}
            {{--            title: '店铺名称',--}}
            {{--            width: '12%',--}}
            {{--            unresize: 'false',--}}
            {{--        }, {--}}
            {{--            field: 'username',--}}
            {{--            title: '商家账号',--}}
            {{--            width: '8%',--}}
            {{--            unresize: 'false'--}}
            {{--        }, {--}}
            {{--            field: 'group_name',--}}
            {{--            title: '开店套餐',--}}
            {{--            width: '10%',--}}
            {{--            unresize: 'false'--}}
            {{--        }, {--}}
            {{--            field: 'category_name',--}}
            {{--            title: '主营行业',--}}
            {{--            width: '8%',--}}
            {{--            unresize: 'false'--}}
            {{--        }, {--}}
            {{--            field: 'is_own',--}}
            {{--            title: '是否自营',--}}
            {{--            width: '8%',--}}
            {{--            unresize: 'false',--}}
            {{--            templet: '#is_own'--}}
            {{--        }, {--}}
            {{--            field: 'site_area_name',--}}
            {{--            title: '城市分站',--}}
            {{--            width: '8%',--}}
            {{--            unresize: 'false',--}}
            {{--            templet: function(data) {--}}
            {{--                return data.site_area_name == '全国' ? '--' : data.site_area_name;--}}
            {{--            }--}}
            {{--        }, {--}}
            {{--            field: 'cert_id',--}}
            {{--            title: '店铺认证',--}}
            {{--            width: '7%',--}}
            {{--            unresize: 'false',--}}
            {{--            templet: function(data) {--}}
            {{--                return data.cert_id == 0 ? '<span style="color: red">未认证</span>' : '<span style="color: green">已认证</span>';--}}
            {{--            }--}}
            {{--        }, {--}}
            {{--            field: 'shop_status',--}}
            {{--            title: '店铺状态',--}}
            {{--            width: '7%',--}}
            {{--            templet: '#status',--}}
            {{--            unresize: 'false'--}}
            {{--        }, {--}}
            {{--            field: 'create_time',--}}
            {{--            title: '入驻时间',--}}
            {{--            width: '10%',--}}
            {{--            unresize: 'false',--}}
            {{--            templet: function(data) {--}}
            {{--                return ns.time_to_date(data.create_time);--}}
            {{--            }--}}
            {{--        }, {--}}
            {{--            field: 'expire_time',--}}
            {{--            title: '到期时间',--}}
            {{--            width: '10%',--}}
            {{--            unresize: 'false',--}}
            {{--            templet: function(data) {--}}
            {{--                return ns.time_to_date(data.expire_time);--}}
            {{--            }--}}
            {{--        }, {--}}
            {{--            title: '操作',--}}
            {{--            width: '10%',--}}
            {{--            toolbar: '#operation',--}}
            {{--            unresize: 'false'--}}
            {{--        }]--}}
            {{--    ]--}}
            {{--});--}}


            {{--/**--}}
            {{-- * 搜索功能--}}
            {{-- */--}}
            {{--form.on('submit(search)', function(data) {--}}
            {{--    table.reload({--}}
            {{--        page: {--}}
            {{--            curr: 1--}}
            {{--        },--}}
            {{--        where: data.field--}}
            {{--    });--}}
            {{--    return false;--}}
            {{--});--}}

            {{--// 城市分站--}}
            {{--form.on('submit(search_website)', function(data) {--}}
            {{--    table_website.reload({--}}
            {{--        page: {--}}
            {{--            curr: 1--}}
            {{--        },--}}
            {{--        where: data.field--}}
            {{--    });--}}
            {{--    return false;--}}
            {{--});--}}


            {{--//批量导出--}}
            {{--form.on('submit(export)', function(data){--}}
            {{--    data.field.order_type = 1;--}}
            {{--    location.href = ns.url("admin/shop/exportShop",data.field);--}}
            {{--    return false;--}}
            {{--});--}}

            {{--/**--}}
            {{-- * 监听工具栏操作--}}
            {{-- */--}}
            {{--table.tool(function(obj) {--}}
            {{--    var data = obj.data,--}}
            {{--        event = obj.event;--}}
            {{--    switch (event) {--}}
            {{--        case 'basic': //基本信息--}}
            {{--            location.href = ns.url("admin/shop/basicInfo" + "?site_id=" + data.site_id);--}}
            {{--            break;--}}
            {{--        case 'identify': //认证信息--}}
            {{--            location.href = ns.url("admin/shop/certInfo" + "?site_id=" + data.site_id)--}}
            {{--            break;--}}
            {{--        // case 'settlement': //结算信息--}}
            {{--        // 	location.href = ns.url("admin/shop/settlementInfo" + "?site_id=" + data.site_id)--}}
            {{--        // 	break;--}}
            {{--        // case 'account': //账户信息--}}
            {{--        // 	location.href = ns.url("admin/shop/accountInfo" + "?site_id=" + data.site_id)--}}
            {{--        // 	break;--}}
            {{--    }--}}
            {{--});--}}

            {{--table_website.tool(function(obj) {--}}
            {{--    var data = obj.data,--}}
            {{--        event = obj.event;--}}
            {{--    switch (event) {--}}
            {{--        case 'basic': //基本信息--}}
            {{--            location.href = ns.url("admin/shop/basicInfo" + "?site_id=" + data.site_id);--}}
            {{--            break;--}}
            {{--        case 'identify': //认证信息--}}
            {{--            location.href = ns.url("admin/shop/certInfo" + "?site_id=" + data.site_id)--}}
            {{--            break;--}}
            {{--        // case 'settlement': //结算信息--}}
            {{--        // 	location.href = ns.url("admin/shop/settlementInfo" + "?site_id=" + data.site_id)--}}
            {{--        // 	break;--}}
            {{--        // case 'account': //账户信息--}}
            {{--        // 	location.href = ns.url("admin/shop/accountInfo" + "?site_id=" + data.site_id)--}}
            {{--        // 	break;--}}
            {{--    }--}}
            {{--});--}}
        });
    </script>
@endsection
