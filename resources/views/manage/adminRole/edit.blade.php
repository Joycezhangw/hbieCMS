@extends('manage.layouts.layout')
@section('content')
    <form class="layui-form hb-form">
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>角色名称：</label>
            <div class="layui-input-block hb-len-long">
                <input name="role_title" type="text" placeholder="请输入角色名称" maxlength="30" lay-verify="title"
                       lay-verify="required" value="{{$role->role_title}}"
                       class="layui-input" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>角色名称最长不超过30个字符</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">角色描述：</label>
            <div class="layui-input-block hb-len-long">
                <textarea name="role_desc" placeholder="请输入角色描述" class="layui-textarea">{{$role->role_desc}}</textarea>
            </div>
            <div class="hb-word-aux">
                <p>角色描述最多不超过500个字符</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>设置权限：</label>
            <div class="layui-input-block">
                <div class="layui-input-inline group-tree-block" id="tree_box">

                </div>
            </div>
        </div>
        <div class="hb-form-row">
            {{ csrf_field() }}
            <button class="layui-btn hb-bg-color" lay-submit="" lay-filter="save">保存</button>
            <button type="reset" class="layui-btn layui-btn-primary" onclick="back()">返回</button>
        </div>
    </form>
@endsection
@section('javascript')
    <script>
        var saveUrl = "{{route('manage.adminRole.update',$role->role_id)}}", indexUrl = "{{route('manage.adminRole.index')}}", TREE_DATA =<?php echo json_encode($rules);?>;;
    </script>
    <script type="text/javascript" src="/static/manage/js/rule_tree.js"></script>
    <script type="text/javascript" src="/static/manage/js/save_role.js"></script>
@endsection
