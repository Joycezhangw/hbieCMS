@extends('manage.layouts.layout')
@section('content')
    <div class="layui-collapse hb-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">操作提示<i class="layui-icon layui-colla-icon"></i></h2>
            <ul class="layui-colla-content layui-show">
                <li>1、用于后台菜单展示，以及管理员角色配置权限</li>
                <li>2、权限菜单最高不能超过4级层次</li>
                <li>3、权限菜单排序越低越靠前</li>
                <li>4、仅限开发人员操作，其他人员请勿操作</li>
            </ul>
        </div>
    </div>
    <div class="hb-single-filter-box">
        <a href="{{route('manage.adminRule.create')}}" class="layui-btn hb-bg-color">添加权限规则</a>
    </div>
    <div class="manage_module_list">
        <table class="layui-table hb-pithy-table">
            <thead>
            <tr>
                <th width="1%"></th>
                <th width="10%">规则名</th>
                <th width="10%" class="text-center">所属项目模块</th>
                <th width="10%" class="text-center">路由</th>
                <th width="10%" class="text-center">是否是菜单</th>
                <th width="10%">排序</th>
                <th width="12%">操作</th>
            </tr>
            </thead>
            <tbody>
            @if($modules)
                @foreach($modules as $key => $v1)
                    <tr>
                        <td>
                            @if(isset($v1['children']))
                                <b class="layui-icon layui-icon-addition text-blue hb-cursor__pointer J-switch"
                                   title="展开"
                                   data-module_id="{{$v1['module_id']}}" data-module_level="{{$v1['module_level']}}"
                                   data-open="1"></b>
                            @endif
                        </td>
                        <td>{{$v1['module_name']}}</td>
                        <td class="text-center">{{$v1['module']}}</td>
                        <td class="text-center"><span class="layui-badge layui-bg-blue">{{$v1['module_route']}}</span></td>
                        <td class="text-center"><i
                                class="layui-icon @if(intval($v1['is_menu'])===1) text-green layui-icon-ok @else text-red layui-icon-close @endif"></i>
                        </td>
                        <td class="text-center">
                            <input type="number" class="layui-input hb-len-short" value="{{$v1['module_sort']}}"
                                   onchange="editSort('{{$v1['module_id']}}')"
                                   id="module_sort{{$v1['module_id']}}">
                        </td>
                        <td class="text-center">
                            <div class="hb-table-btn">
                                <a href="{{route('manage.adminRule.edit',$v1['module_id'])}}"
                                   class="layui-btn">编辑</a>
                            </div>
                        </td>
                    </tr>
                    @if(isset($v1['children']))
                        @foreach($v1['children'] as $v2)
                            <tr data-module_id_{{$v1['module_level']}}="{{$v1['module_id']}}" style="display: none">
                                <td>
                                </td>
                                <td style="padding-left: 20px;">
                                    @if(isset($v2['children']))
                                        <b class="layui-icon layui-icon-subtraction text-blue hb-cursor__pointer J-switch"
                                           title="展开"
                                           data-module_id="{{$v2['module_id']}}"
                                           data-module_level="{{$v2['module_level']}}"
                                           data-open="0" style="padding-right: 20px"></b>
                                    @endif
                                    {{$v2['module_name']}}</td>
                                <td class="text-center">{{$v2['module']}}</td>
                                <td class="text-center"><span class="layui-badge layui-bg-blue">{{$v2['module_route']}}</span></td>
                                <td class="text-center"><i
                                        class="layui-icon @if(intval($v2['is_menu'])===1) text-green layui-icon-ok @else text-red layui-icon-close @endif"></i>
                                </td>
                                <td class="text-center">
                                    <input type="number" class="layui-input hb-len-short" value="{{$v2['module_sort']}}"
                                           onchange="editSort('{{$v2['module_id']}}')"
                                           id="module_sort{{$v2['module_id']}}">
                                </td>
                                <td class="text-center">
                                    <div class="hb-table-btn">
                                        <a href="{{route('manage.adminRule.edit',$v2['module_id'])}}" class="layui-btn">编辑</a>
                                    </div>
                                </td>
                            </tr>
                            @if(isset($v2['children']))
                                @foreach($v2['children'] as $v3)
                                    <tr data-module_id_{{$v1['module_level']}}="{{$v1['module_id']}}"
                                        data-module_id_{{$v2['module_level']}}="{{$v2['module_id']}}"
                                        style="display: none">
                                        <td>
                                        </td>
                                        <td style="padding-left: 80px;">
                                            @if(isset($v3['children']))
                                                <b class="layui-icon layui-icon-subtraction text-blue hb-cursor__pointer J-switch"
                                                   title="展开"
                                                   data-module_id="{{$v3['module_id']}}"
                                                   data-module_level="{{$v3['module_level']}}"
                                                   data-open="0" style="padding-right: 20px"></b>
                                            @endif
                                            {{$v3['module_name']}}</td>
                                        <td class="text-center">{{$v3['module']}}</td>
                                        <td class="text-center"><span class="layui-badge layui-bg-blue">{{$v3['module_route']}}</span></td>
                                        <td class="text-center"><i
                                                class="layui-icon @if(intval($v3['is_menu'])===1) text-green layui-icon-ok @else text-red layui-icon-close @endif"></i>
                                        </td>
                                        <td class="text-center">
                                            <input type="number" class="layui-input hb-len-short"
                                                   value="{{$v3['module_sort']}}"
                                                   onchange="editSort('{{$v3['module_id']}}')"
                                                   id="module_sort{{$v3['module_id']}}">
                                        </td>
                                        <td class="text-center">
                                            <div class="hb-table-btn">
                                                <a href="{{route('manage.adminRule.edit',$v3['module_id'])}}"
                                                   class="layui-btn">编辑</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @if(isset($v3['children']))
                                        @foreach($v3['children'] as $v4)
                                            <tr data-module_id_{{$v1['module_level']}}="{{$v1['module_id']}}"
                                                data-module_id_{{$v2['module_level']}}="{{$v2['module_id']}}"
                                                data-module_id_{{$v3['module_level']}}="{{$v3['module_id']}}"
                                                style="display: none">
                                                <td>
                                                </td>
                                                <td style="padding-left: 120px;">
                                                    {{$v4['module_name']}}</td>
                                                <td class="text-center">{{$v4['module']}}</td>
                                                <td class="text-center"><span class="layui-badge layui-bg-blue">{{$v4['module_route']}}</span></td>
                                                <td class="text-center"><i
                                                        class="layui-icon @if(intval($v4['is_menu'])===1) text-green layui-icon-ok @else text-red layui-icon-close @endif"></i>
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" class="layui-input hb-len-short"
                                                           value="{{$v4['module_sort']}}"
                                                           onchange="editSort('{{$v4['module_id']}}')"
                                                           id="module_sort{{$v4['module_id']}}">
                                                </td>
                                                <td class="text-center">
                                                    <div class="hb-table-btn">
                                                        <a href="{{route('manage.adminRule.edit',$v4['module_id'])}}"
                                                           class="layui-btn">编辑</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif

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
        function editSort(module_id) {
            var sort = $("#module_sort" + module_id).val();

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
                url: '{{route("manage.adminRule.modifyFiled")}}',
                data: {
                    _token: "{{csrf_token()}}",
                    id: module_id,
                    field_name: 'module_sort',
                    field_value: sort
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
                var name = ".manage_module_list .layui-table tr[data-module_id_" + level + "='" + module_id + "']";
                console.log(name);
                console.log($(name))
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
