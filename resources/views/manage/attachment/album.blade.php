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
    <style>
        .album-container {
            display: flex;
            flex-direction: row;
            flex: 1;
            flex-basis: auto;
            box-sizing: border-box;
            min-width: 0;
            height: 100vh;
        }

        .album-container.is-vertical {
            flex-direction: column;
        }

        .album-aside, .album-header {
            box-sizing: border-box;
            flex-shrink: 0;
        }

        .album-aside, .album-main {
            overflow: auto;
        }

        .album-footer, .album-main {
            box-sizing: border-box;
        }

        .album-footer, .album-header {
            color: #333;
            line-height: 60px;
            height: 60px;
            padding: 0 20px;
        }

        .album-aside {
            width: 200px;
            background-color: rgb(238, 241, 246);
            color: #333;
        }

        .album-main {
            display: block;
            flex: 1;
            flex-basis: auto;
            padding: 20px;
        }

        .layui-nav {
            border-right: 1px solid #e6e6e6;
            list-style: none;
            position: relative;
            margin: 0;
            padding-left: 0;
            background-color: #fff;
            color: #333;
        }

        .layui-nav .layui-nav-item a {
            color: #333;
        }

        .layui-nav .layui-nav-more {
            content: '';
            width: 0;
            height: 0;
            border-style: solid dashed dashed;
            border-color: #333 transparent transparent;
            overflow: hidden;
            cursor: pointer;
            transition: all .2s;
            -webkit-transition: all .2s;
            position: absolute;
            top: 50%;
            right: 3px;
            margin-top: -3px;
            border-width: 6px;
            border-top-color: #333;
        }

        .layui-nav .layui-nav-mored, .layui-nav-itemed > a .layui-nav-more {
            margin-top: -9px;
            border-style: dashed dashed solid;
            border-color: transparent transparent #333;
        }

        .layui-nav-itemed > a, .layui-nav-tree .layui-nav-title a, .layui-nav-tree .layui-nav-title a:hover {
            color: #333 !important;
        }

        .layui-nav-itemed > .layui-nav-child {
            background: none !important;
        }

        .layui-nav-tree .layui-nav-item a:hover {
            background-color: #ecf5ff;
            color: #333;
        }

        .layui-nav-tree .layui-nav-bar {
            background-color: #c0cddc;
        }

        .layui-nav-tree .layui-nav-child dd.layui-this, .layui-nav-tree .layui-nav-child dd.layui-this a, .layui-nav-tree .layui-this, .layui-nav-tree .layui-this > a, .layui-nav-tree .layui-this > a:hover {
            background-color: #ecf5ff;
            color: #409eff;
        }

        .mod-photo-list {
            position: relative;
            *zoom: 1;
        }

        .mod-photo-list-ul {
            display: flex;
            flex-wrap: wrap;
        }

        .mod-photo-li {
            width: 164px;
            height: 154px;
            margin: 0 15px 15px 0;
            float: left;
            border: 1px solid #ecf5ff


        }

        .mod-photo-item {

        }

        .mod-photo-item .item-bd {
            position: relative;
            *zoom: 1;
            z-index: 2;
        }

        .mod-photo-item .item-cover {
            display: block;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: #DEDEDE;
            width: 164px;
            height: 124px;
        }

        .mod-photo-item .item-cover .pic {
            width: 208px;
            height: 123px;
            margin: 0px -22px;
            opacity: 1;
        }

        .mod-photo-item .item-ft {
            position: relative;
            z-index: 1;
            background-color: #ecf5ff;
            *zoom: 1;
        }

        .mod-photo-item .item-ft .item-tit {
            padding: 5px 0;
            height: 20px;
            line-height: 20px;
            padding-left: 10px;
            font-size: 12px;
            text-align: left;
            border-width: 1px;
        }

        .mod-photo-item .item-ft .item-tit span {
            display: inline-block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .mod-photo-item .item-ft .item-tit span {
            display: inline-block;
            width: 94%;
        }

        .empty-data {
            width: 100%;
            text-align: center;
        }

        .mod-photo-li .photo-active-box {
            position: absolute;
            z-index: 1;
            top: 0;
            right: 0;
            display: none;
        }

        .mod-photo-li .photo-active-box:after {
            content: '';
            display: block;
            position: absolute;
            top: 0px;
            right: 0;
            border: 15px solid;
            border-color: transparent;
            border-top-color: #FF5722;
            border-right-color: #FF5722;
        }

        .mod-photo-li .photo-active-box span.active-index {
            position: absolute;
            top: 1px;
            right: 1px;
            color: #fff;
            z-index: 2;
            font-style: normal;
            line-height: 1;
        }

        .mod-photo-li:hover, .mod-photo-li.is_active {
            border-color: #FF5722;
        }

        .mod-photo-li.is_active .photo-active-box {
            display: block;
        }
    </style>
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
            limit: 12,
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
                    if(top.window.tinyMceFilemanager){
                        top.window.tinyMceFilemanager.pic_arr=ALBUM.activeFileArr;
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
                size: 1024 * 2 ,//限制文件大小，单位 KB
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
