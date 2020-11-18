@extends('manage.layouts.layout')
@section('content')
    <form class="layui-form hb-form">
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>栏目：</label>
            <div class="layui-input-inline">
                <select name="pid" lay-verify="channel">
                    <option value="0">顶级栏目</option>
                    @foreach($channels as $channel)
                        <option value="{{$channel->channel_id}}">{{$channel->channel_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
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
            <label class="layui-form-label">小程序跳转页面：</label>
            <div class="layui-input-block hb-len-long">
                <input name="page_path" type="text" placeholder="请输入小程序跳转页面"  class="layui-input"
                       autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>小程序跳转页面，例如：/pages/article/index?channel_id=10002</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否允许添加内容：</label>
            <div class="layui-input-block">
                <input type="checkbox" name="is_allow_content" lay-skin="switch" value="1" checked>
            </div>
            <div class="hb-word-aux">
                <p>当设置了“小程序跳转页面”，也不允许添加内容的时候，请不要选中</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否是通知公告：</label>
            <div class="layui-input-block">
                <input type="checkbox" name="is_notice" lay-skin="switch" value="0">
            </div>
            <div class="hb-word-aux">
                <p>如果是通知公告，将展示在通知公告中</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否显示：</label>
            <div class="layui-input-block">
                <input type="checkbox" name="is_show" lay-skin="switch" value="1" checked>
            </div>
            <div class="hb-word-aux">
                <p>用于控制前台是否展示</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图标：</label>
            <div class="layui-input-block">
                <input type="hidden" name="channel_icon" value="" lay-verify="channel_icon">
                <div class="hb-upload__img">
                    <div class="hb-upload__img--box" id="imgUploadCover">
                        <div class="hb-upload-default">
                            <img src="/static/manage/images/upload_img.png"/>
                            <p>点击上传</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hb-word-aux">
                <p>建议图片尺寸：128px * 128px。统一比例为1:1,正方形。图片格式：png。</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序：</label>
            <div class="layui-input-block">
                <input name="channel_sort" type="number" value="0" placeholder="请输入排序" lay-verify="num"
                       class="layui-input hb-len-short" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>排序值必须为整数</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">栏目描述：</label>
            <div class="layui-input-block hb-len-long">
                <textarea name="channel_desc" placeholder="请输入栏目描述" class="layui-textarea"></textarea>
            </div>
            <div class="hb-word-aux">
                <p>栏目描述最多不超过500个字符</p>
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
        var SAVE_URL="{{route('manage.channel.store')}}",INDEX_URL="{{route('manage.channel.index')}}",HB_UPLOAD_URL = "{{route('manage.upload.upload')}}", CSRF_TOKEN = "{{csrf_token()}}";
    </script>
    <script type="text/javascript" src="/static/manage/js/save_channel.js"></script>
@endsection
