<?php

use Illuminate\Routing\Router;

Route::group([
    'prefix' => 'manage',
    'namespace' => 'Manage'
], function (Router $router) {
    $router->get('/', 'Login@index');
    $router->get('login', 'Login@index')->name('manage.login.index');
    $router->post('login', 'Login@login')->name('manage.login');
    $router->get('logout', 'Login@logout')->name('manage.logout');
    $router->get('captcha', 'Login@captcha')->name('manage.captcha');

    //验证登录状态
    $router->group([
        'middleware' => 'rbac.admin',
    ], function (Router $router) {
        $router->get('index', 'Index@index')->name('manage.index.index');
        //上传附件
        $router->post('upload/upload', 'Upload@doUpload')->name('manage.upload.upload');
        $router->get('attachment/album', 'Attachment@album')->name('manage.attachment.album');
        $router->get('attachment/albumFile', 'Attachment@albumFile')->name('manage.attachment.albumFile');
        //验证是否由权限
        $router->group([
            'middleware' => 'rbac.admin.permissiion',
        ], function (Router $router) {
            //管理员
            $router->get('admin/index', 'Admin@index')->name('manage.admin.index');
            $router->get('admin/create', 'Admin@create')->name('manage.admin.create');
            $router->get('admin/edit', 'Admin@edit')->name('manage.admin.edit');
            $router->post('admin/store', 'Admin@store')->name('manage.admin.store');
            $router->post('admin/modifyFiled', 'Admin@modifyFiled')->name('manage.admin.modifyFiled');
            $router->post('admin/resetPwd', 'Admin@resetPwd')->name('manage.admin.resetPwd');
            $router->post('admin/update/{id}', 'Admin@update')->name('manage.admin.update');
            //管理员角色
            $router->get('role/index', 'AdminRole@index')->name('manage.adminRole.index');
            $router->get('role/create', 'AdminRole@create')->name('manage.adminRole.create');
            $router->get('role/edit/{id}', 'AdminRole@edit')->name('manage.adminRole.edit');
            $router->post('role/store', 'AdminRole@store')->name('manage.adminRole.store');
            $router->post('role/update/{id}', 'AdminRole@update')->name('manage.adminRole.update');
            //管理员日志
            $router->get('log/index', 'AdminLog@index')->name('manage.adminLog.index');
            $router->post('log/destroy', 'AdminLog@destroy')->name('manage.adminLog.destroy');
            //菜单权限规则
            $router->get('rule/index', 'AdminRule@index')->name('manage.adminRule.index');
            $router->get('rule/create', 'AdminRule@create')->name('manage.adminRule.create');
            $router->get('rule/edit/{id}', 'AdminRule@edit')->name('manage.adminRule.edit');
            $router->post('rule/store', 'AdminRule@store')->name('manage.adminRule.store');
            $router->post('rule/update/{id}', 'AdminRule@update')->name('manage.adminRule.update');
            $router->post('rule/modifyFiled', 'AdminRule@modifyFiled')->name('manage.adminRule.modifyFiled');
            $router->post('rule/destroy/{id}', 'AdminRule@destroy')->name('manage.adminRule.destroy');

            //会员管理
            $router->get('member/index', 'Member@index')->name('manage.member.index');
            $router->get('member/create', 'Member@create')->name('manage.member.create');
            $router->get('member/edit', 'Member@edit')->name('manage.member.edit');
            $router->post('member/store', 'Member@store')->name('manage.member.store');
            $router->post('member/update/{id}', 'Member@update')->name('manage.member.update');
            $router->post('member/resetPwd', 'Member@resetPwd')->name('manage.member.resetPwd');
            $router->post('member/modifyFiled', 'Member@modifyFiled')->name('manage.member.modifyFiled');
            //用户组
            $router->get('group/index', 'MemberGroup@index')->name('manage.memberGroup.index');
            $router->get('group/create', 'MemberGroup@create')->name('manage.memberGroup.create');
            $router->get('group/edit/{id}', 'MemberGroup@edit')->name('manage.memberGroup.edit');
            $router->post('group/store', 'MemberGroup@store')->name('manage.memberGroup.store');
            $router->post('group/update/{id}', 'MemberGroup@update')->name('manage.memberGroup.update');
            $router->post('group/modifyFiled', 'MemberGroup@modifyFiled')->name('manage.memberGroup.modifyFiled');


            //栏目管理
            $router->get('channel/index', 'Channel@index')->name('manage.channel.index');
            $router->get('channel/create', 'Channel@create')->name('manage.channel.create');
            $router->get('channel/edit/{id}', 'Channel@edit')->name('manage.channel.edit');
            $router->post('channel/store', 'Channel@store')->name('manage.channel.store');
            $router->post('channel/update/{id}', 'Channel@update')->name('manage.channel.update');
            $router->post('channel/modifySort', 'Channel@modifySort')->name('manage.channel.modifySort');
            $router->post('channel/modifyFiled', 'Channel@modifyFiled')->name('manage.channel.modifyFiled');
            $router->post('channel/destroy/{id}', 'Channel@destroy')->name('manage.channel.destroy');

            //内容管理
            $router->get('article/index', 'Article@index')->name('manage.article.index');
            $router->get('article/create', 'Article@create')->name('manage.article.create');
            $router->get('article/edit', 'Article@edit')->name('manage.article.edit');
            $router->post('article/store', 'Article@store')->name('manage.article.store');
            $router->post('article/update/{id}', 'Article@update')->name('manage.article.update');
            $router->post('article/destroy/{id}', 'Article@destroy')->name('manage.article.destroy');
            $router->post('article/modifyFiled', 'Article@modifyFiled')->name('manage.article.modifyFiled');

            //幻灯片
            $router->get('slide/index', 'Slide@index')->name('manage.slide.index');
            $router->get('slide/create', 'Slide@create')->name('manage.slide.create');
            $router->get('slide/edit', 'Slide@edit')->name('manage.slide.edit');
            $router->post('slide/store', 'Slide@store')->name('manage.slide.store');
            $router->post('slide/update/{id}', 'Slide@update')->name('manage.slide.update');
            $router->post('slide/modifySort', 'Slide@modifySort')->name('manage.slide.modifySort');
            $router->post('slide/destroy/{id}', 'Slide@destroy')->name('manage.slide.destroy');
            //附件管理
            $router->get('attachment/index', 'Attachment@index')->name('manage.attachment.index');
            $router->post('attachment/store', 'Attachment@store')->name('manage.attachment.store');
            $router->post('attachment/update', 'Attachment@update')->name('manage.attachment.update');
            $router->post('attachment/destroy', 'Attachment@destroy')->name('manage.attachment.destroy');

            //首页金刚区域九宫格管理
            $router->get('mpPages/index', 'MpPages@index')->name('manage.mpPages.index');
            $router->get('mpPages/create', 'MpPages@create')->name('manage.mpPages.create');
            $router->get('mpPages/edit/{id}', 'MpPages@edit')->name('manage.mpPages.edit');
            $router->post('mpPages/store', 'MpPages@store')->name('manage.mpPages.store');
            $router->post('mpPages/update/{id}', 'MpPages@update')->name('manage.mpPages.update');
            $router->post('mpPages/modifySort', 'MpPages@modifySort')->name('manage.mpPages.modifySort');
            $router->post('mpPages/destroy/{id}', 'MpPages@destroy')->name('manage.mpPages.destroy');
        });

    });
});
