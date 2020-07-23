@extends('manage.layouts.layout')
@section('stylesheet')
    <link type="text/css" rel="stylesheet" href="/static/manage/css/photo.css"/>
@endsection
@section('content')
    <div class="layui-collapse hb-tips">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">操作提示<i class="layui-icon layui-colla-icon"></i></h2>
            <ul class="layui-colla-content layui-show">
                <li>主要用于管理上传到服务器或第三方存储的附件数据</li>
                <li>删除分组时，仅删除分组，不删除图片，组内图片将自动归入默认分组</li>
            </ul>
        </div>
    </div>
    <div class="hb-single-filter-box padding-bottom-sm">
        <button type="button" class="layui-btn layui-btn-normal" id="imgUploadCover"><i class="layui-icon"></i>上传图片
        </button>
    </div>
    <section class="album-container" style="height: 600px">
        <aside class="album-aside">
            <div class="text-center padding-top-xs">
                <button class="layui-btn layui-btn-primary hb-text-color hb-border-color J-add_grouping">添加分组
                </button>
            </div>
            <div id="album-sidebar"></div>
        </aside>
        <section class="album-container is-vertical" style="height: 600px">
            <header class="album-header">
                当前分组：<span id="current-group" class="text-blue "></span>
            </header>
            <main class="album-main padding-top-0">
                <div class="mod-photo-list">
                    <ul class="mod-photo-list-ul" id="albumImg"></ul>
                </div>
                <div id="paged" class="page"></div>
            </main>
        </section>
    </section>
    <script type="text/html" id="albumList">
        @{{# layui.each(d.list,function(index,item){ }}
        <li data-pic-id="@{{item.file_id}}" data-json_data='@{{JSON.stringify(item)}}' class="mod-photo-li">
            <div class="mod-photo-item">
                <div class="item-bd">
                    <a href="javascript:;" class="item-cover">
                        <img src="@{{ item.file_path_url }}" class="pic" alt="@{{item.file_name}}">
                    </a>
                    <div class="photo-active-box">
                        <span class="active-index layui-icon layui-icon-ok"></span>
                    </div>
                </div>
                <div class="item-ft">
                    <div class="item-tit">
                        <span>@{{ item.file_name }}</span>
                    </div>
                </div>
            </div>
        </li>
        @{{# }) }}
        @{{#  if(d.list.length === 0){ }}
        <div class="empty-data">
            @component('manage.layouts.empty')
            @endcomponent
        </div>
        @{{#  } }}
    </script>
@endsection
@section('javascript')
    <script>
        var ALBUM = {
            album_id: 0,
            limit: 20,
            album_menu:<?php echo json_encode($menus);?>,
            upload_url: "{{route('manage.upload.upload')}}",
            album_file_url: "{{route('manage.attachment.albumFile')}}",
            csrf_token: "{{csrf_token()}}",
            laytpl: null,
            laypage: null,
            layTree: null,
            action_flag: {
                flag_add_group: false,//分组防重标识
                flag_modify_group: false,
                flag_delete_group: false
            },
            albumFileList: function (page) {//获取图片列表
                $.ajax({
                    url: ALBUM.album_file_url,
                    type: "get",
                    dataType: "JSON",
                    async: false,
                    data: {
                        album_id: ALBUM.album_id,
                        page_size: ALBUM.limit,
                        page
                    },
                    success: function (res) {
                        ALBUM.laytpl($("#albumList").html()).render(res.data, function (data) {
                            $("#albumImg").html(data);
                        });

                        if (res.data.total > 0) {
                            ALBUM.laypage.render({
                                elem: 'paged',
                                count: res.data.total,
                                limit: ALBUM.limit,
                                curr: page,
                                jump: function (obj, first) {
                                    if (!first) {
                                        ALBUM.albumFileList(obj.curr);
                                    }
                                }
                            })
                        }
                    }
                })
            },
            selectChildren: function (id) {//是否存在子节点
                var data = ALBUM.album_menu;
                for (var i in data) {
                    if (parseInt(data[i].pid) === id) {
                        return true;
                    }
                }
                return false;
            },
            getChildren: function (id) {//递归体  即对每条data逐条递归找children
                var tempArray = [], data = ALBUM.album_menu;
                for (var i in data) {
                    if (parseInt(data[i].pid) === id) {
                        var tempChild = {};
                        tempChild.title = data[i].album_name;
                        tempChild.id = data[i].album_id;
                        tempChild.is_default = data[i].is_default;
                        if (ALBUM.selectChildren(data[i].album_id)) {   //若存在子节点，继续递归；否则为叶节点，停止递归
                            tempChild.children = ALBUM.getChildren(data[i].album_id);
                        }
                        tempArray.push(tempChild);
                    }
                }
                return tempArray;
            },
            listToTree: function () {//将数组转成指定格式的tree
                var formatData = [], data = ALBUM.album_menu;
                for (var i in data) {     // pId为0时表示为根节点
                    if (parseInt(data[i].pid) === 0) {
                        var tempObject = {};
                        tempObject.title = data[i].album_name;
                        tempObject.id = data[i].album_id;
                        tempObject.is_default = data[i].is_default;
                        tempObject.checked = parseInt(data[i].is_default) === 1 ? true : false;
                        tempObject.children = ALBUM.getChildren(tempObject.id);
                        formatData.push(tempObject);
                    }
                }
                return formatData;
            },
            addGrouping() {//创建分组
                layer.prompt({
                    formType: 3,
                    title: '添加分组',
                    area: ["350px"]
                }, function (value, index, elem) {
                    if (ALBUM.action_flag.flag_add_group) return;
                    ALBUM.action_flag.flag_add_group = true;
                    $.ajax({
                        url: '{{route("manage.attachment.store")}}',
                        data: {
                            album_name: value,
                            _token: ALBUM.csrf_token
                        },
                        type: "POST",
                        dataType: "JSON",
                        success: function (res) {
                            layer.msg(res.message);
                            ALBUM.action_flag.flag_add_group = false;
                            if (res.code === 200) {
                                ALBUM.album_menu.push(res.data);
                                ALBUM.layTree.reload('albumMenu', {
                                    data: ALBUM.listToTree(),
                                });
                                layer.close(index);
                            }
                        }, error(err) {
                            ALBUM.action_flag.flag_add_group = false;
                        }
                    })
                })
            },
            editGrouping: function (obj) {//修改分组
                if (ALBUM.action_flag.flag_modify_group) return;
                ALBUM.action_flag.flag_modify_group = true;
                $.ajax({
                    url: "{{route('manage.attachment.update')}}",
                    data: {
                        album_name: obj.data.title,
                        album_id: obj.data.id,
                        _token: ALBUM.csrf_token
                    },
                    type: "POST",
                    dataType: "JSON",
                    success: function (res) {
                        layer.msg(res.message);
                        ALBUM.action_flag.flag_modify_group = false;
                        if (res.code === 200) {
                        }
                    },error(err){
                        ALBUM.action_flag.flag_modify_group = false;
                    }
                })
            },
            deleteGrouping: function (obj) {
                if (ALBUM.action_flag.flag_delete_group) return;
                ALBUM.action_flag.flag_delete_group = true;
                $.ajax({
                    url: "{{route('manage.attachment.destroy')}}",
                    data: {
                        album_id: obj.data.id,
                        _token: ALBUM.csrf_token
                    },
                    type: "POST",
                    dataType: "JSON",
                    success: function (res) {
                        layer.msg(res.message);
                        ALBUM.action_flag.flag_delete_group = false;
                        if (res.code === 200) {
                        }
                    },error(err){
                        ALBUM.action_flag.flag_delete_group = false;
                    }
                })
            },
            initBind() {
                $('.J-add_grouping').on('click', function () {
                    ALBUM.addGrouping();
                })
            }
        };
        ALBUM.initBind();
        layui.use(['upload', 'laytpl', 'laypage', 'tree'], function () {
            var element = layui.element, $ = layui.jquery, upload = layui.upload;
            ALBUM.layTree = layui.tree;
            ALBUM.laytpl = layui.laytpl;
            ALBUM.laypage = layui.laypage;
            ALBUM.album_id = ALBUM.album_menu[0].album_id;
            $('#current-group').text(ALBUM.album_menu[0].album_name);
            ALBUM.albumFileList(1);
            //普通图片上传
            upload.render({
                elem: '#imgUploadCover',
                url: ALBUM.upload_url,
                data: {
                    file_type: 'image',
                    folder: 'article',
                    album_id: function () {
                        return ALBUM.album_id
                    },
                    _token: ALBUM.csrf_token
                },
                size: 1024 * 2,//限制文件大小，单位 KB
                exts: 'jpg|jpeg|png|gif', //只允许上传压缩文件
                done: function (res) {
                    if (res.code === 200) {
                        var file = {'list': [res.data]};
                        ALBUM.laytpl($('#albumList').html()).render(file, function (str) {
                            $("#albumImg").prepend(str);
                        });
                    }
                    return layer.msg(res.message);
                }
            });
            ALBUM.layTree.render({
                elem: '#album-sidebar',
                id: 'albumMenu',
                data: ALBUM.listToTree(),
                edit: ['update', 'del'],
                click: function (obj) {
                    ALBUM.album_id = obj.data.id;
                    $('#current-group').text(obj.data.title);
                    ALBUM.albumFileList(1)
                }, operate: function (obj) {
                    if (obj.type === "update") {
                        ALBUM.editGrouping(obj)
                    } else if (obj.type === 'del') {
                        ALBUM.deleteGrouping(obj)
                    }
                }
            });
        });
    </script>
@endsection
