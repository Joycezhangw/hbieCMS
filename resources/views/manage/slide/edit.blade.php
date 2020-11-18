@extends('manage.layouts.layout')
@section('content')
    <form class="layui-form hb-form">
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>幻灯片名称：</label>
            <div class="layui-input-block hb-len-long">
                <input name="slide_name" type="text" placeholder="请输入内容标题" lay-verify="title" maxlength="60"
                       lay-verify="required" value="{{$slide['slide_name']}}"
                       class="layui-input" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>幻灯片名称最长不超过60个字符</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">跳转地址：</label>
            <div class="layui-input-block hb-len-long">
                <input name="slide_page" type="text" value="{{$slide['slide_page']}}" placeholder="跳转地址" class="layui-input" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>用于小程序端，添加图片跳转到目标页面</p>
                <p>例如：</p>
                <p>1、内容：/pages/article/detail?id=内容ID&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{route('manage.article.index')}}"
                                                                                target="_blank" style="color: red">查看内容id</a>
                </p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否展示：</label>
            <div class="layui-input-block">
                <input type="checkbox" name="is_show" lay-skin="switch" value="1" @if(intval($slide['is_show'])===1) checked  @endif>
            </div>
            <div class="hb-word-aux">
                <p>用于控制小程序首页是否展示</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>展示图片：</label>
            <div class="layui-input-block">
                <input type="hidden" name="slide_pic" value="{{$slide['slide_pic']}}" lay-verify="slide_pic">
                <div class="hb-upload__img">
                    <div class="hb-upload__img--box" id="imgUploadCover">
                        @if($slide['slide_pic']=='')
                            <div class="hb-upload-default">
                                <img src="/static/manage/images/upload_img.png"/>
                                <p>点击上传</p>
                            </div>
                        @else
                            <img src="{{$slide['slide_pic_url']}}">
                        @endif
                    </div>
                </div>
            </div>
            <div class="hb-word-aux">
                <p>建议图片尺寸：750px * 422px。统一比例为：16:9。图片格式：jpg、png、jpeg。</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序：</label>
            <div class="layui-input-block">
                <input name="slide_sort" type="number" value="{{$slide['slide_sort']}}" placeholder="请输入排序" lay-verify="num"
                       class="layui-input hb-len-short" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>排序值必须为整数，用于小程序端显示顺序，越小越靠前</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">描述：</label>
            <div class="layui-input-block hb-len-long">
                <textarea name="slide_desc" placeholder="请输入幻灯片描述" lay-verify="slide_desc"
                          class="layui-textarea">{{$slide['slide_desc']}}</textarea>
            </div>
            <div class="hb-word-aux">
                <p>幻灯片描述最多不超过500个字符</p>
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
        var SAVE_URL = "{{route('manage.slide.update',$slide['slide_id'])}}", INDEX_URL = "{{route('manage.slide.index')}}",
            HB_UPLOAD_URL = "{{route('manage.upload.upload')}}", CSRF_TOKEN = "{{csrf_token()}}";
    </script>
    <script type="text/javascript" src="/static/manage/js/save_slide.js"></script>
@endsection
