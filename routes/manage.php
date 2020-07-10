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

    $router->group([
        'middleware' => 'rbac.admin',
    ], function (Router $router) {
        $router->get('index', 'Index@index')->name('manage.index.index');
        //管理员
        $router->get('admin/index', 'Admin@index')->name('manage.admin.index');
        $router->get('admin/create', 'Admin@create')->name('manage.admin.create');
        $router->get('admin/edit/{id}', 'Admin@edit')->name('manage.admin.edit');
        $router->post('admin/store', 'Admin@store')->name('manage.admin.store');
        $router->post('admin/update/{id}', 'Admin@update')->name('manage.admin.update');
        //管理员角色
        $router->get('role/index', 'AdminRole@index')->name('manage.adminRole.index');
        $router->get('role/create', 'AdminRole@create')->name('manage.adminRole.create');
        $router->get('role/edit/{id}', 'AdminRole@edit')->name('manage.adminRole.edit');
        $router->post('role/store', 'AdminRole@store')->name('manage.adminRole.store');
        $router->post('role/update/{id}', 'AdminRole@update')->name('manage.adminRole.update');
        //管理员日志
        $router->get('log/index', 'AdminLog@index')->name('manage.adminLog.index');
        $router->post('log/destroy/{id}', 'AdminLog@destroy')->name('manage.adminLog.destroy');
        //菜单权限规则
        $router->get('rule/index', 'AdminRule@index')->name('manage.adminRule.index');
        $router->get('rule/create', 'AdminRule@create')->name('manage.adminRule.create');
        $router->get('rule/edit/{id}', 'AdminRule@edit')->name('manage.adminRule.edit');
        $router->post('rule/store', 'AdminRule@store')->name('manage.adminRule.store');
        $router->post('rule/update/{id}', 'AdminRule@update')->name('manage.adminRule.update');
        $router->post('rule/destroy/{id}', 'AdminRule@destroy')->name('manage.adminRule.destroy');

        //栏目管理
        $router->get('channel/index', 'Channel@index')->name('manage.channel.index');
        $router->get('channel/create', 'Channel@create')->name('manage.channel.create');
        $router->get('channel/edit/{id}', 'Channel@edit')->name('manage.channel.edit');
        $router->post('channel/store', 'Channel@store')->name('manage.channel.store');
        $router->post('channel/update/{id}', 'Channel@update')->name('manage.channel.update');
        $router->post('channel/destroy/{id}', 'Channel@destroy')->name('manage.channel.destroy');

        //内容管理
        $router->get('article/index', 'Article@index')->name('manage.article.index');
        $router->get('article/create', 'Article@create')->name('manage.article.create');
        $router->get('article/edit/{id}', 'Article@edit')->name('manage.article.edit');
        $router->post('article/store', 'Article@store')->name('manage.article.store');
        $router->post('article/update/{id}', 'Article@update')->name('manage.article.update');
        $router->post('article/destroy/{id}', 'Article@destroy')->name('manage.article.destroy');

    });
});
