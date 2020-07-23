<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>图片、视频、文档 - 专辑管理</title>
    <link type="text/css" rel="stylesheet" href="/static/ac/lib/layui/css/layui.css"/>
    <link type="text/css" rel="stylesheet" href="/static/manage/css/common.css"/>
    <link type="text/css" rel="stylesheet" href="/static/manage/css/photo_menu.css"/>
    <link type="text/css" rel="stylesheet" href="/static/manage/css/photo.css"/>
    <!-- [if lt IE 9]-->
    <script type="text/javascript" src="/static/ac/lib/html5shiv.min.js"></script>
    <script type="text/javascript" src="/static/ac/lib/respond.min.js"></script>
    <!-- [endif] -->
</head>
<body>
<div class="album-container">
    <section class="album-container">
        <aside class="album-aside">
            <ul class="layui-nav layui-nav-tree layui-inline" lay-filter="album-menu" id="album-sidebar"></ul>
        </aside>
        <section class="album-container is-vertical">
            <header class="album-header">
                <button type="button" class="layui-btn layui-btn-normal" id="imgUploadCover"><i class="layui-icon"></i>上传图片
                </button>
                @if(intval($select_num)>0)
                    <span class="padding-left-xs">已选中<span id="active_num" class="text-red padding-left-xs">0</span>/{{$select_num}}</span>
                @endif
            </header>
            <main class="album-main">
                <div class="mod-photo-list">
                    <ul class="mod-photo-list-ul" id="albumImg"></ul>
                </div>
                <div id="paged" class="page"></div>
            </main>
        </section>
    </section>
</div>
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
<script type="text/javascript" src="/static/ac/lib/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/static/ac/lib/layui/layui.js"></script>
<script>
    window.ALBUM = window.ALBUM || {};
    $(function () {
        ALBUM = {
            album_id: 0,
            limit: 20,
            select_num:{{$select_num}},
            file_type: '{{$file_type}}',
            album_menu:<?php echo json_encode($menus);?>,
            activeFileArr: [],
            upload_url: "{{route('manage.upload.upload')}}",
            album_file_url: "{{route('manage.attachment.albumFile')}}",
            csrf_token: "{{csrf_token()}}",
            menuCell: 1,
            laytpl: null,
            laypage: null,
            mainMenu: function () {
                var lists = [], menus = ALBUM.album_menu;
                // 遍历生成主菜单
                for (var i = 0; i < menus.length; i++) {
                    // 判断是否存在子菜单
                    if (menus[i].children != null && menus[i].children.length > 0) {
                        var child = [];
                        // 遍历获取子菜单
                        for (var k = 0; k < menus[i].children.length; k++) {
                            child.push(ALBUM.getChildMenu(menus[i].children[k], 0));
                        }
                        lists.push('<li class="layui-nav-item"><a href="javascript:;" data-album_id=' + menus[i].album_id + '>' + menus[i].album_name + '</a><dl class="layui-nav-child">' + child.join('') + '</dl></li>');
                    } else {
                        lists.push('<li class="layui-nav-item"><a href="javascript:;" data-album_id=' + menus[i].album_id + '>' + menus[i].album_name + '</a></li>');
                    }
                }
                $("#album-sidebar").html(lists.join(''));
            },
            getChildMenu: function (subMenu, num) {
                num++;
                var lists = [];
                if (subMenu.children != null && subMenu.children.length > 0) {
                    var child = [];
                    for (var j = 0; j < subMenu.children.length; j++) {
                        child.push(ALBUM.getChildMenu(subMenu.children[j], num));
                    }
                    lists.push('<dd><ul><li class="layui-nav-item"><a href="javascript:;" data-album_id=' + subMenu.album_id + ' style="text-indent: ' + num * ALBUM.menuCell + 'em" >' + subMenu.album_name + '</a><dl class="layui-nav-child">' + child.join('') + '</dl></li></ul></dd>');
                } else {
                    lists.push('<dd><a href="javascript:;" data-album_id=' + subMenu.album_id + ' style="text-indent: ' + num * ALBUM.menuCell + 'em">' + subMenu.album_name + '</a></dd>');
                }
                return lists.join('');
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
                        file_type: ALBUM.file_type,
                        page
                    },
                    success: function (res) {
                        ALBUM.laytpl($("#albumList").html()).render(res.data, function (data) {
                            $("#albumImg").html(data);
                        });
                        //重置数据，清除已选中相片
                        if (ALBUM.select_num > 0) {
                            ALBUM.activeFileArr.length=0;
                            $('#active_num').text(0)
                        }
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
            checkPic: function () {//选中图片
                $("#albumImg").unbind('click').on("click", ".mod-photo-li", function () {
                    var that = $(this), json_data = $(this).data("json_data");
                    if (!that.hasClass('is_active')) {
                        if (ALBUM.select_num > 0) {
                            if (ALBUM.activeFileArr.length < ALBUM.select_num) {
                                that.addClass('is_active')
                                ALBUM.activeFileArr.push(json_data);
                            } else {
                                layer.msg('您已超出最大的图片限额');
                            }
                        } else {
                            that.addClass('is_active')
                            ALBUM.activeFileArr.push(json_data);
                        }
                    } else {
                        ALBUM.doDelActiveArrIdx(json_data.file_id);
                        that.removeClass('is_active')
                    }
                    //父窗口富文本框文件管理存在的情况下，将选中的图片传给父富文本框
                    if (top.window.tinyMceFilemanager) {
                        top.window.tinyMceFilemanager.pic_arr = ALBUM.activeFileArr;
                    }
                    //有选中数量限制，做提示处理
                    if (ALBUM.select_num > 0) {
                        $('#active_num').text(ALBUM.activeFileArr.length)
                    }
                });
            },
            doDelActiveArrIdx(id) {//删除图片
                var delete_index;
                $.each(ALBUM.activeFileArr, function (i, item) {
                    if (item.file_id == id) {
                        delete_index = item.index;
                        ALBUM.activeFileArr.splice(i, 1);
                        return false;
                    }
                });
                return delete_index;
            }
        };
        layui.use(['layer', 'upload', 'laytpl', 'laypage', 'element'], function () {
            var element = layui.element, $ = layui.jquery, upload = layui.upload;
            ALBUM.laytpl = layui.laytpl;
            ALBUM.laypage = layui.laypage;
            ALBUM.album_id = ALBUM.album_menu[0].album_id;
            ALBUM.mainMenu();
            //监听导航点击
            element.on('nav(album-menu)', function (elem) {
                var album_id = parseInt(elem.data('album_id'));
                ALBUM.album_id = album_id;
                ALBUM.albumFileList(1)
            });
            ALBUM.albumFileList(1);
            //普通图片上传
            upload.render({
                elem: '#imgUploadCover',
                url: ALBUM.upload_url,
                data: {
                    file_type: 'image',
                    folder: 'article',
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
            ALBUM.checkPic();
            element.init();
        });
    });
</script>
@yield('javascript')
</body>
</html>
