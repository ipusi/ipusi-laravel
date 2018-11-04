<?php

namespace App\Http\Controllers;

use App\WechatConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Factory;

class WechatController extends Controller
{
    /**
     * Wechat request protal
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function serve(Request $request)
    {
        $config = WechatConfig::where('name', '=', $request->get('name'))->first();
        $wechat = Factory::officalAccout($config);

        $wechat->server->push(
            function ($message) {
                return "欢迎关注！";
            }
        );

        return $wechat->server->serve();
    }
}
