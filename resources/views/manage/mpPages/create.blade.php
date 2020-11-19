@extends('manage.layouts.layout')
@section('content')
    <form class="layui-form hb-form">
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>页面标题：</label>
            <div class="layui-input-block hb-len-long">
                <input name="page_title" type="text" placeholder="请输入页面标题" lay-verify="title" maxlength="6"
                       class="layui-input" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>页面标题最长不超过6个字符</p>
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
            <label class="layui-form-label"><span class="required">*</span>前端路由：</label>
            <div class="layui-input-block hb-len-long">
                <input name="page_url" type="text" placeholder="请输入前端路由"  lay-verify="required"
                       class="layui-input" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>前端路由，例如：/pages/home/index</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图标：</label>
            <div class="layui-input-block">
                <input type="hidden" name="page_icon" value="" lay-verify="page_icon">
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
                <input name="page_sort" type="number" value="0" placeholder="请输入排序" lay-verify="num"
                       class="layui-input hb-len-short" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>排序值必须为整数</p>
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
        var SAVE_URL="{{route('manage.mpPages.store')}}",INDEX_URL="{{route('manage.mpPages.index')}}",HB_UPLOAD_URL = "{{route('manage.upload.upload')}}", CSRF_TOKEN = "{{csrf_token()}}"
    </script>
    <script type="text/javascript" src="/static/manage/js/save_page.js"></script>
@endsection
