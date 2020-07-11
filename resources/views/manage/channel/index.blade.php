@extends('manage.layouts.layout')
@section('content')
    <div class="layui-collapse hb-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">操作提示<i class="layui-icon layui-colla-icon"></i></h2>
            <ul class="layui-colla-content layui-show">
                <li>用于管理网站的内容分类</li>
            </ul>
        </div>
    </div>
    <div class="hb-single-filter-box">
        <a href="{{route('manage.channel.create')}}" class="layui-btn hb-bg-color">添加内容栏目</a>
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
                <th>栏目名称</th>
                <th>简称</th>
                <th>是否显示</th>
                <th>排序</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @if(!$channels->isEmpty())
                @foreach($channels as $key => $channel)
                    <td></td>
                    <td>{{$channel->channel_name}}</td>
                    <td>{{$channel->channel_short_name}}</td>
                    <td>{{intval($channel->is_show)===1?'是':'否'}}</td>
                    <td>
                        <input type="number" class="layui-input hb-len-short" value="{{$channel->channel_sort}}"
                               onchange="editSort('{{$channel->channel_id}}')"
                               id="channel_sort{{$channel->channel_id}}">
                    </td>
                    <td>
                        <div class="hb-table-btn">
                            <a href="{{route('manage.channel.edit',$channel->channel_id)}}" class="layui-btn">编辑</a>
                        </div>
                    </td>
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
        function editSort(channel_id) {
            var sort = $("#channel_sort" + channel_id).val();

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
                url: '{{route("manage.channel.modifySort")}}',
                data: {
                    _token:"{{csrf_token()}}",
                    channel_sort: sort,
                    channel_id: channel_id
                },
                dataType: 'JSON',
                success: function (res) {
                    layer.msg(res.message);
                    if (res.code == 0) {
                        table.reload();
                    }
                }
            });
        }
    </script>
@endsection
