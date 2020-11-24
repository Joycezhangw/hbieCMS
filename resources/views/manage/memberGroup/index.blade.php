@extends('manage.layouts.layout')
@section('content')
    <div class="layui-collapse hb-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">操作提示<i class="layui-icon layui-colla-icon"></i></h2>
            <ul class="layui-colla-content layui-show">
                <li>用户组管理</li>
            </ul>
        </div>
    </div>
    <div class="hb-single-filter-box">
        <a href="{{route('manage.memberGroup.create')}}" class="layui-btn hb-bg-color">添加用户组</a>
    </div>
    <div class="cms-channel">
        <table class="layui-table hb-pithy-table">
            <colgroup>
                <col width="3%">
                <col width="10%">
                <col width="10%">
                <col width="12%">
            </colgroup>
            <thead>
            <tr>
                <th></th>
                <th>组名</th>
                <th>是否系统管理员</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @if($groups)
                @foreach($groups as $key => $group)
                    <tr>
                        <td></td>
                        <td>{{$group['group_title']}}</td>
                        <td><i
                                class="layui-icon @if(intval($group['is_system'])===1) text-green layui-icon-ok @else text-red layui-icon-close @endif"></i>
                        </td>
                        <td>
                            <div class="hb-table-btn">
                                @if(intval($group['is_default'])==1)
                                    不可操作
                                @else
                                    <a href="{{route('manage.memberGroup.edit',$group['group_id'])}}" target="_blank"
                                       class="layui-btn">编辑</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">
                        @component('manage.layouts.empty')
                        @endcomponent
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
