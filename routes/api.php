<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/wechat/{id}/menu', 'WechatController@menu')->name('wechat.menu');
Route::post('/wechat/{id}/menu/publish', 'WechatController@menupublish')
            ->name('wechat.menupublish');
Route::post('/wechat/{id}/menu/clear', 'WechatController@menuclear')
            ->name('wechat.menuclear');
Route::post('/wechat/{id}/material/', 'WechatController@material')
            ->name('wechat.material');


