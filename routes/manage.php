<?php
use Illuminate\Routing\Router;

Route::group([
    'prefix' => 'manage',
    'namespace' => 'Manage'
],function (Router $router){
    $router->get('login', 'Login@index')->name('manage.login.index');
    $router->post('login', 'Login@login')->name('manage.login');
    $router->get('captcha', 'Login@captcha')->name('manage.captcha');
});
