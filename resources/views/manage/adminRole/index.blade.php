@extends('manage.layouts.layout')
@section('content')
    <div class="layui-collapse hb-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">操作提示<i class="layui-icon layui-colla-icon"></i></h2>
            <ul class="layui-colla-content layui-show">
                <li>后台管理员操作角色管理</li>
            </ul>
        </div>
    </div>
    <div class="hb-single-filter-box">
        <a href="{{route('manage.adminRole.create')}}" class="layui-btn hb-bg-color">添加角色</a>
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
                <th>角色名</th>
                <th>描述</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @if(!$roles->isEmpty())
                @foreach($roles as $key => $role)
                    <tr>
                        <td></td>
                        <td>{{$role->role_title}}</td>
                        <td>{{$role->role_desc}}</td>
                        <td>
                            <div class="hb-table-btn">
                                @if(intval($role->is_default)==1)
                                    不可编辑
                                @else
                                    <a href="{{route('manage.adminRole.edit',$role->role_id)}}" target="_blank"
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
