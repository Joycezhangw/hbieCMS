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
        $router->get('index', 'Index@index')->name('manage.index');
    });
});
