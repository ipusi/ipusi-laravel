<?php

namespace App\Http\Controllers;

use App\WechatConfig;
use EasyWeChat\Factory;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    /**
     * Wechat request protal 消息处理
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function serve(Request $request, $id = 1)
    {
        $this->_configs = WechatConfig::where('id', '=', $id)
            ->select(['app_id', 'secret', 'aes_key' ])
            ->first()
            ->toArray();
        $this->_wechat = Factory::officialAccount($this->_configs);
        $this->_wechat->server->push(
            function ($message) {
                return "欢迎关注！";
            }
        );

        return $wechat->server->serve();
    }

    /**
     * Get current menu config
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return json($menu)
     */
    public function menu(Request $request, $id)
    {
        $this->_configs = WechatConfig::where('id', '=', $id)
            ->select(['app_id', 'secret', 'aes_key', 'name' ])
            ->first()
            ->toArray();
        $this->_wechat = Factory::officialAccount($this->_configs);
        $current = $this->_wechat->menu->list();
        return response()->json(['list' => $current,'name' => $this->_configs['name'] ]);
    }

    /**
     * Publish menu
     *
     * @param \Illuminate\Http\Request $request
     * @param [type] $id
     *
     * @return void
     */
    public function menupublish(Request $request, $id)
    {
        $this->_configs = WechatConfig::where('id', '=', $id)
            ->select(['app_id', 'secret', 'aes_key' ])
            ->first()
            ->toArray();
        $this->_wechat = Factory::officialAccount($this->_configs);
        // 清除所有菜单
        // $this->_wechat->menu->delete();
        // 重新发布菜单
        $menu = json_decode($request->get('menu'));
        $response = $this->_wechat->menu->create($menu->button);
        return response()->json($response);
    }

    /**
     * Clear all menu
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function menuclear(Request $request, $id)
    {
        $this->_configs = WechatConfig::where('id', '=', $id)
            ->select(['app_id', 'secret', 'aes_key' ])
            ->first()
            ->toArray();
        $this->_wechat = Factory::officialAccount($this->_configs);
        // 清除所有菜单
        $response = $this->_wechat->menu->delete();
        return response()->json($response);
    }

    public function material(Request $request, $id)
    {
        $this->_configs = WechatConfig::where('id', '=', $id)
            ->select(['app_id', 'secret', 'aes_key' ])
            ->first()
            ->toArray();
        $this->_wechat = Factory::officialAccount($this->_configs);
        $news = $this->_wechat->material->list('news', 0, 10);
        return response()->json($news);
    }
}
