@extends('manage.layouts.layout')
@section('content')
    <form class="layui-form hb-form">
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>用户组名称：</label>
            <div class="layui-input-block hb-len-long">
                <input name="group_title" type="text" value="{{$group->group_title}}" placeholder="请输入用户组名称" maxlength="16" lay-verify="title"
                       lay-verify="required"
                       class="layui-input" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>用户组名称最长不超过16个字符</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>用户组类型：</label>
            <div class="layui-input-block hb-len-long" id="role_box">
                <select name="group_type">
                    <option value="member" @if($group->group_type==='member') selected @endif>普通用户</option>
                    <option value="system" @if($group->group_type==='system') selected @endif>系统用户</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否系统用户组：</label>
            <div class="layui-input-block">
                <input type="checkbox" name="is_system" lay-skin="switch" value="1" @if(intval($group->group_type)===1) checked @endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">用户组描述：</label>
            <div class="layui-input-block hb-len-long">
                <textarea name="group_remark" placeholder="请输入用户组描述" class="layui-textarea">{{$group->group_remark}}</textarea>
            </div>
            <div class="hb-word-aux">
                <p>用户组描述最多不超过500个字符</p>
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
        var saveUrl = "{{route('manage.memberGroup.update',$group->group_id)}}", indexUrl = "{{route('manage.memberGroup.index')}}";
    </script>
    <script type="text/javascript" src="/static/manage/js/save_group.js"></script>
@endsection
