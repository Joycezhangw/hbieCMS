@extends('manage.layouts.layout')
@section('content')
    <form class="layui-form hb-form">
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>栏目名称：</label>
            <div class="layui-input-block hb-len-long">
                <input name="channel_name" type="text" placeholder="请输入栏目名称" maxlength="30" lay-verify="required"
                       class="layui-input" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>栏目名称最长不超过30个字符</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">简称：</label>
            <div class="layui-input-block hb-len-long">
                <input name="channel_short_name" type="text" placeholder="请输入简称" maxlength="20" class="layui-input"
                       autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>栏目名过长设置简称方便显示，字数设置为不超过20个字符</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否显示：</label>
            <div class="layui-input-block">
                <input type="checkbox" name="is_show" lay-skin="switch" value="1" checked="">
                <div class="layui-unselect layui-form-switch layui-form-onswitch" lay-skin="_switch"><em></em><i></i>
                </div>
            </div>
            <div class="hb-word-aux">
                <p>用于控制前台是否展示</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序：</label>
            <div class="layui-input-block">
                <input name="sort" type="number" value="0" placeholder="请输入排序" lay-verify="num"
                       class="layui-input hb-len-short" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>排序值必须为整数</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">栏目描述：</label>
            <div class="layui-input-block hb-len-long">
                <textarea name="description" placeholder="请输入栏目描述" class="layui-textarea"></textarea>
            </div>
            <div class="hb-word-aux">
                <p>栏目描述最多不超过500个字符</p>
            </div>
        </div>
    </form>
@endsection
@section('javascript')
    <script>
        layui.use('form', function(){
            var form = layui.form;

            //监听提交
            form.on('submit(formDemo)', function(data){
                layer.msg(JSON.stringify(data.field));
                return false;
            });
        });
    </script>
@endsection
