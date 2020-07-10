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
                        <input type="number" class="layui-input hb-len-short" value=" {{$channel->channel_sort}}"
                               onchange="editSort('{{$channel->channel_id}}')"
                               id="category_sort{{$channel->channel_id}}">
                    </td>
                    <td>
                        <a href="" class="layui-btn">编辑</a>
                    </td>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">
                        <div class="hb-empty hb-empty-normal">
                            <div class="hb-empty-image">
                                <svg class="hb-empty-img-simple" width="64" height="41" viewBox="0 0 64 41"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g transform="translate(0 1)" fill="none" fill-rule="evenodd">
                                        <ellipse class="hb-empty-img-simple-ellipse" cx="32" cy="33" rx="32"
                                                 ry="7"></ellipse>
                                        <g class="hb-empty-img-simple-g" fill-rule="nonzero">
                                            <path
                                                d="M55 12.76L44.854 1.258C44.367.474 43.656 0 42.907 0H21.093c-.749 0-1.46.474-1.947 1.257L9 12.761V22h46v-9.24z"></path>
                                            <path
                                                d="M41.613 15.931c0-1.605.994-2.93 2.227-2.931H55v18.137C55 33.26 53.68 35 52.05 35h-40.1C10.32 35 9 33.259 9 31.137V13h11.16c1.233 0 2.227 1.323 2.227 2.928v.022c0 1.605 1.005 2.901 2.237 2.901h14.752c1.232 0 2.237-1.308 2.237-2.913v-.007z"
                                                class="hb-empty-img-simple-path"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <p class="hb-empty-description">暂无数据</p></div>
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
        function editSort(category_id) {
            var sort = $("#category_sort"+category_id).val();

            if (!new RegExp("^-?[1-9]\\d*$").test(sort)) {
                layer.msg("排序号只能是整数");
                return;
            }
            if(sort<0){
                layer.msg("排序号必须大于0");
                return ;
            }
            $.ajax({
                type: 'POST',
                url: '',
                data: {
                    sort: sort,
                    category_id: category_id
                },
                dataType: 'JSON',
                success: function(res) {
                    layer.msg(res.message);
                    if (res.code == 0) {
                        table.reload();
                    }
                }
            });
        }
    </script>
@endsection
