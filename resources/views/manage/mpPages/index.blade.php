@extends('manage.layouts.layout')
@section('content')
    <style>
        .page_img{
            width: 32px;
            height: 32px;
        }
    </style>
    <div class="layui-collapse hb-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">操作提示<i class="layui-icon layui-colla-icon"></i></h2>
            <ul class="layui-colla-content layui-show">
                <li>1、用于管理前端首页九宫格展示</li>
                <li>1、排序越低越靠前</li>
            </ul>
        </div>
    </div>
    <div class="hb-single-filter-box">
        <a href="{{route('manage.mpPages.create')}}" class="layui-btn hb-bg-color">添加页面</a>
    </div>
    <div class="cms-channel">
        <table class="layui-table hb-pithy-table">
            <colgroup>
                <col width="3%">
                <col width="25%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="12%">
            </colgroup>
            <thead>
            <tr>
                <th></th>
                <th>页面名称</th>
                <th>路由</th>
                <th>是否显示</th>
                <th>排序</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @if($pages)
                @foreach($pages as $key => $item)
                    <tr>
                        <td>
                        </td>
                        <td><img class="page_img" src="{{$item['page_icon_url']}}">{{$item['page_title']}}</td>
                        <td>{{$item['page_url']}}</td>
                        <td>{{intval($item['is_show'])===1?'是':'否'}}</td>
                        <td>
                            <input type="number" class="layui-input hb-len-short" value="{{$item['page_sort']}}"
                                   onchange="editSort('{{$item['page_id']}}')"
                                   id="page_sort{{$item['page_id']}}">
                        </td>
                        <td>
                            <div class="hb-table-btn">
                                <a href="{{route('manage.mpPages.edit',$item['page_id'])}}" target="_blank" class="layui-btn">编辑</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">
                        @component('manage.layouts.empty')
                        @endcomponent
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
@section('javascript')
    <script>
        // 监听单元格编辑
        function editSort(page_id) {
            var sort = $("#page_sort" + page_id).val();

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
                url: '{{route("manage.mpPages.modifySort")}}',
                data: {
                    _token:"{{csrf_token()}}",
                    page_sort: sort,
                    page_id: page_id
                },
                dataType: 'JSON',
                success: function (res) {
                    layer.msg(res.message);
                }
            });
        }
    </script>
@endsection
