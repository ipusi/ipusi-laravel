<?php

namespace App\Admin\Controllers;

use App\WechatConfig;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Layout\Content;
// use Encore\Admin\Widgets\Box;
// use Encore\Admin\Widgets\Collapse;
// use Encore\Admin\Widgets\Table;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;

class WechatManageController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function menu(Content $content)
    {
        $tab = new Tab();

        $wechatconfig = new WechatConfig();
        $configs = $wechatconfig::all();
        foreach ($configs as $key => $config) { 
            // print $config;
            $tab->add(''.$config['name'], view('wechat.menu', ['id'=>$config['id']]));
        }
        
        
        return $content
            ->header('微信菜单管理')
            ->description('管理微信菜单')
            ->row($tab);
    }

    // /**
    //  * Show interface.
    //  *
    //  * @param mixed $id
    //  * @param Content $content
    //  * @return Content
    //  */
    // public function show($id, Content $content)
    // {
    //     return $content
    //         ->header('Detail')
    //         ->description('description')
    //         ->body($this->detail($id));
    // }

    // /**
    //  * Edit interface.
    //  *
    //  * @param mixed $id
    //  * @param Content $content
    //  * @return Content
    //  */
    // public function edit($id, Content $content)
    // {
    //     return $content
    //         ->header('Edit')
    //         ->description('description')
    //         ->body($this->form()->edit($id));
    // }

    // /**
    //  * Create interface.
    //  *
    //  * @param Content $content
    //  * @return Content
    //  */
    // public function create(Content $content)
    // {
    //     return $content
    //         ->header('Create')
    //         ->description('description')
    //         ->body($this->form());
    // }

    // /**
    //  * Make a grid builder.
    //  *
    //  * @return Grid
    //  */
    // protected function grid()
    // {
    //     $grid = new Grid(new WechatConfig);

    //     $grid->id('Id');
    //     $grid->catagory('Catagory');
    //     $grid->name('Name');
    //     $grid->app_id('App id');
    //     $grid->secret('Secret');
    //     $grid->aes_key('Aes key');
    //     $grid->created_at('Created at');
    //     $grid->updated_at('Updated at');
    //     $grid->user_id('User id');

    //     //禁用批量操作
    //     $grid->disableRowSelector();

    //     return $grid;
    // }

    // /**
    //  * Make a show builder.
    //  *
    //  * @param mixed $id
    //  * @return Show
    //  */
    // protected function detail($id)
    // {
    //     $show = new Show(WechatConfig::findOrFail($id));

    //     $show->id('Id');
    //     $show->catagory('Catagory');
    //     $show->name('Name');
    //     $show->app_id('App id');
    //     $show->secret('Secret');
    //     $show->aes_key('Aes key');
    //     $show->created_at('Created at');
    //     $show->updated_at('Updated at');
    //     $show->user_id('User id');

    //     return $show;
    // }

    // /**
    //  * Make a form builder.
    //  *
    //  * @return Form
    //  */
    // protected function form()
    // {
    //     $form = new Form(new WechatConfig);

    //     $form->text('catagory', 'Catagory');
    //     $form->text('name', 'Name');
    //     $form->text('app_id', 'App id');
    //     $form->text('secret', 'Secret');
    //     $form->text('aes_key', 'Aes key');
    //     $form->number('user_id', 'User id');

    //     return $form;
    // }


    // /**
    //  *  菜单栏
    //  *
    //  * @return Tab
    //  */
    // protected function menu()
    // {
    //     $tab = new Tab();
    //     $tab->add('爱普斯科技', '11111');
    //     $tab->add('西安旅游FM', '11111');

    //     return $tab;
    // }

    // /**
    //  * 微信菜单编辑
    //  *
    //  * @return view
    //  */
    // protected function wechatmenu()
    // {
    //     return view('wechat.menu');
    // }
}
