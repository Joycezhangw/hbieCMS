@extends('manage.layouts.layout')
@section('content')
    <form class="layui-form hb-form">
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>栏目名称：</label>
            <div class="layui-input-block hb-len-long">
                <input name="channel_name" type="text" placeholder="请输入栏目名称" maxlength="30" lay-verify="required"
                       class="layui-input" autocomplete="off" value="{{$channel->channel_name}}">
            </div>
            <div class="hb-word-aux">
                <p>栏目名称最长不超过30个字符</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">简称：</label>
            <div class="layui-input-block hb-len-long">
                <input name="channel_short_name" type="text" placeholder="请输入简称" maxlength="20" class="layui-input"
                       autocomplete="off" value="{{$channel->channel_short_name}}">
            </div>
            <div class="hb-word-aux">
                <p>栏目名过长设置简称方便显示，字数设置为不超过20个字符</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否显示：</label>
            <div class="layui-input-block">
                <input type="checkbox" name="is_show" lay-skin="switch" value="{{$channel->is_show}}"
                       @if(intval($channel->is_show)===1) checked @endif>
            </div>
            <div class="hb-word-aux">
                <p>用于控制前台是否展示</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序：</label>
            <div class="layui-input-block">
                <input name="channel_sort" type="number" value="{{$channel->channel_sort}}" placeholder="请输入排序"
                       lay-verify="num"
                       class="layui-input hb-len-short" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>排序值必须为整数</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">栏目描述：</label>
            <div class="layui-input-block hb-len-long">
                <textarea name="channel_desc" placeholder="请输入栏目描述"
                          class="layui-textarea">{{$channel->channel_desc}}</textarea>
            </div>
            <div class="hb-word-aux">
                <p>栏目描述最多不超过500个字符</p>
            </div>
        </div>
        <div class="hb-form-row">
            <input type="hidden" name="pid" id="pid" value="0">
            {{ csrf_field() }}
            <button class="layui-btn hb-bg-color" lay-submit="" lay-filter="save">保存</button>
            <button type="reset" class="layui-btn layui-btn-primary" onclick="back()">返回</button>
        </div>
    </form>
@endsection
@section('javascript')
    <script>
        var saveUrl="{{route('manage.channel.update',$channel->channel_id)}}",indexUrl="{{route('manage.channel.index')}}";
    </script>
    <script type="text/javascript" src="/static/manage/js/save_channel.js"></script>
@endsection
