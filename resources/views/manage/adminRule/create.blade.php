@extends('manage.layouts.layout')
@section('content')
    <div class="layui-collapse hb-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">操作提示<i class="layui-icon layui-colla-icon"></i></h2>
            <ul class="layui-colla-content layui-show">
                <li>仅限开发人员操作，其他人员请勿操作</li>
            </ul>
        </div>
    </div>
    <form class="layui-form hb-form">
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>权限规则名称：</label>
            <div class="layui-input-block hb-len-long">
                <input name="module_name" type="text" placeholder="请输入规则名称" maxlength="30" lay-verify="required"
                       class="layui-input" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>规则名称最长不超过30个字符</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>所属项目模块：</label>
            <div class="layui-input-block hb-len-long">
                <input name="module" type="text" value="manage" readonly placeholder="请输入项目模块" maxlength="20"
                       class="layui-input"
                       autocomplete="off">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>上级权限规则：</label>
            <div class="layui-input-inline">
                <select name="pid" lay-verify="channel">
                    <option value="0">顶级权限规则</option>
                    @foreach($modules as $module)
                        <option
                            value="{{$module['module_id']}}">{!! $module['html'] !!}{{$module['module_name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="hb-word-aux">
                <p>上级权限规则是必选项，这里只显示是后台菜单，并且深度是小于4级的权限规则</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>控制器名：</label>
            <div class="layui-input-block hb-len-long">
                <input name="controller" type="text" value="" placeholder="请输入路由所对应的控制器名"
                       class="layui-input" lay-verify="required"
                       autocomplete="off">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="required">*</span>方法名：</label>
            <div class="layui-input-block hb-len-long">
                <input name="method" type="text" value="" placeholder="请输入路由所对应的方法名"
                       class="layui-input" lay-verify="required"
                       autocomplete="off">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限规则路由：</label>
            <div class="layui-input-block hb-len-long">
                <input name="module_route" type="text" value="" placeholder="请输入路由" class="layui-input"
                       autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>路由格式：manage.article.destroy</p>
                <p>权限规则路由是必填项，如果第二级菜单下面有第三级菜单，那么第二级菜单一定不要填写路由，留空就行</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否菜单：</label>
            <div class="layui-input-block">
                <input type="checkbox" name="is_menu" lay-skin="switch" value="0">
            </div>
            <div class="hb-word-aux">
                <p>用于是否展示在后台菜单栏中</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序：</label>
            <div class="layui-input-block">
                <input name="module_sort" type="number" value="0" placeholder="请输入排序" lay-verify="num"
                       class="layui-input hb-len-short" autocomplete="off">
            </div>
            <div class="hb-word-aux">
                <p>排序值必须为整数</p>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限规则描述：</label>
            <div class="layui-input-block hb-len-long">
                <textarea name="module_desc" placeholder="请输入权限规则描述" class="layui-textarea"></textarea>
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
        var saveUrl = "{{route('manage.adminRule.store')}}", indexUrl = "{{route('manage.adminRule.index')}}";
    </script>
    <script type="text/javascript" src="/static/manage/js/save_module.js"></script>
@endsection
