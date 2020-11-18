@extends('manage.layouts.layout')
@section('content')
    <div class="layui-collapse hb-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">操作提示<i class="layui-icon layui-colla-icon"></i></h2>
            <ul class="layui-colla-content layui-show">
                <li>1、用于管理网站的内容分类</li>
                <li>2、排序越低越靠前</li>
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
                <col width="6%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="12%">
            </colgroup>
            <thead>
            <tr>
                <th></th>
                <th>编号</th>
                <th>栏目名称</th>
                <th>简称</th>
                <th>是否显示</th>
                <th>是否公告</th>
                <th>是否允许添加内容</th>
                <th>排序</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @if($channels)
                @foreach($channels as $key => $channel)
                    <tr>
                        <td>
                            @if(isset($channel['children']))
                                <b class="layui-icon layui-icon-addition text-blue hb-cursor__pointer J-switch"
                                   title="展开"
                                   data-module_id="{{$channel['channel_id']}}" data-module_level="{{$key}}"
                                   data-open="1"></b>
                            @endif
                        </td><td>
                            {{$channel['channel_id']}}
                        </td>
                        <td>@if($channel['channel_icon_url']!=='')<img src="{{$channel['channel_icon_url']}}" style="width: 40px;height: 40px"/>@endif{{$channel['channel_name']}}</td>
                        <td>{{$channel['channel_short_name']}}</td>
                        <td>{{intval($channel['is_show'])===1?'是':'否'}}</td>
                        <td>{{intval($channel['is_notice'])===1?'是':'否'}}</td>
                        <td>{{intval($channel['is_allow_content'])===1?'是':'否'}}</td>
                        <td>
                            <input type="number" class="layui-input hb-len-short" value="{{$channel['channel_sort']}}"
                                   onchange="editSort('{{$channel['channel_id']}}')"
                                   id="channel_sort{{$channel['channel_id']}}">
                        </td>
                        <td>
                            <div class="hb-table-btn">
                                <a href="{{route('manage.channel.edit',$channel['channel_id'])}}" target="_blank" class="layui-btn">编辑</a>
                            </div>
                        </td>
                    </tr>
                    @if(isset($channel['children']))
                        @foreach($channel['children'] as $v2)
                            <tr data-module_id_{{$key}}="{{$channel['channel_id']}}" style="display: none">
                                <td>
                                </td>
                                <td style="padding-left: 40px;">
                                    {{$v2['channel_id']}}
                                </td>
                                <td>@if($v2['channel_icon_url']!=='')<img src="{{$v2['channel_icon_url']}}" style="width: 40px;height: 40px"/>@endif{{$v2['channel_name']}}</td>
                                <td>{{$v2['channel_short_name']}}</td>
                                <td>{{intval($v2['is_show'])===1?'是':'否'}}</td>
                                <td>{{intval($v2['is_notice'])===1?'是':'否'}}</td>
                                <td>{{intval($v2['is_allow_content'])===1?'是':'否'}}</td>
                                <td>
                                    <input type="number" class="layui-input hb-len-short" value="{{$v2['channel_sort']}}"
                                           onchange="editSort('{{$v2['channel_id']}}')"
                                           id="channel_sort{{$v2['channel_id']}}">
                                </td>
                                <td>
                                    <div class="hb-table-btn">
                                        <a href="{{route('manage.channel.edit',$v2['channel_id'])}}" target="_blank" class="layui-btn">编辑</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="9" class="text-center">
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
                }
            });
        }
        $(function () {
            $('.J-switch').click(function () {
                var that = $(this), module_id = that.data('module_id'), level = that.data('module_level'),
                    open = parseInt(that.data('open').toString());
                var name = ".cms-channel .layui-table tr[data-module_id_" + level + "='" + module_id + "']";
                if (open === 1) {
                    $(name).show();
                    that.removeClass("layui-icon-addition").addClass('layui-icon-subtraction');
                } else {
                    $(name).hide();
                    that.removeClass("layui-icon-subtraction").addClass('layui-icon-addition');
                }
                that.data('open', (open === 1 ? 0 : 1))
            })
        })
    </script>
@endsection
