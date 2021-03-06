<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    ], function (Router $router) {
        $router->get('/', 'HomeController@index');
        $router->resource('/wechat/config', WechatConfigController::class);
        $router->resource('/cms/post', PostController::class);
        $router->resource('/cms/comment', CommentController::class);
        $router->get('/wechat/menu', 'WechatManageController@menu');
});
