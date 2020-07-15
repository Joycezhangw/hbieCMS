@extends('manage.layouts.layout')
@section('content')
    <form class="layui-form hb-form">
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>内容标题：</label>
            <div class="layui-input-block hb-len-long">
                <input name="post_title" type="text" placeholder="请输入内容标题" lay-verify="title" maxlength="60"
                       lay-verify="required"
                       class="layui-input" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>内容标题最长不超过60个字符</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>栏目：</label>
            <div class="layui-input-inline">
                <select name="channel_id" lay-verify="channel">
                    <option value="0">请选择栏目</option>
                    @foreach($channels as $channel)
                        <option value="{{$channel->channel_id}}">{{$channel->channel_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">来源：</label>
            <div class="layui-input-block hb-len-long">
                <input name="post_source" type="text" placeholder="请输入内容来源"  maxlength="128"
                       lay-verify="required"
                       class="layui-input" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>内容来源，比如：福建留学人员创业园</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否显示：</label>
            <div class="layui-input-block">
                <input type="checkbox" name="post_status" lay-skin="switch" value="1" checked>
            </div>
            <div class="hb-word-aux">
                <p>用于控制前台是否展示</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否推荐首页：</label>
            <div class="layui-input-block">
                <input type="checkbox" name="is_home_rec" lay-skin="switch" value="0">
            </div>
            <div class="hb-word-aux">
                <p>用于小程序首页是否展示，在前台中栏目的是否显示比内容的权重更高</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>内容封面图片：</label>
            <div class="layui-input-block">
                <input type="hidden" name="post_pic" value="" lay-verify="post_pic">
                <div class="hb-upload__img">
                    <div class="hb-upload__img--box" id="imgUploadCover">
                        <div class="hb-upload-default">
                            <img src="/static/images/upload_img.png"/>
                            <p>点击上传</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hb-word-aux">
                <p>建议图片尺寸：650px * 366px。统一比例为：16:9。图片格式：jpg、png、jpeg。</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">标签：</label>
            <div class="layui-input-block hb-tags" id="tags">
                <input type="text" name="post_tags" id="inputTags" placeholder="空格键生成标签" autocomplete="off">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>内容描述：</label>
            <div class="layui-input-block hb-len-long">
                <textarea name="post_desc" placeholder="请输入内容描述" lay-verify="post_desc"
                          class="layui-textarea"></textarea>
            </div>
            <div class="hb-word-aux">
                <p>栏目描述最多不超过500个字符</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>详细内容：</label>
            <div class="layui-input-block hb-len-long">
                <textarea name="post_content" id="post_content" style="display: none" lay-verify="post_content"
                          placeholder="请输入详细内容"
                          class="layui-textarea"></textarea>
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
        var SAVE_URL = "{{route('manage.article.store')}}", INDEX_URL = "{{route('manage.article.index')}}",
            HB_TAGS = [], HB_UPLOAD_URL = "{{route('manage/upload/upload')}}", CSRF_TOKEN = "{{csrf_token()}}";
    </script>
    <script type="text/javascript" src="/static/manage/js/save_article.js"></script>
@endsection
