<?php

namespace App\Http\Controllers;

use App\wechat_menu;
use Illuminate\Http\Request;

class WechatMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('wechat.menu');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\wechat_menu  $wechat_menu
     * @return \Illuminate\Http\Response
     */
    public function show(wechat_menu $wechat_menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\wechat_menu  $wechat_menu
     * @return \Illuminate\Http\Response
     */
    public function edit(wechat_menu $wechat_menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\wechat_menu  $wechat_menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, wechat_menu $wechat_menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\wechat_menu  $wechat_menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(wechat_menu $wechat_menu)
    {
        //
    }
}
