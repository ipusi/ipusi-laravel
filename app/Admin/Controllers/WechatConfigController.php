<?php

namespace App\Admin\Controllers;

use App\WechatConfig;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class WechatConfigController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('公众号配置')
            ->description('配置公众号信息')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WechatConfig);

        $grid->id('Id');
        $grid->catagory('Catagory');
        $grid->name('Name');
        $grid->app_id('App id');
        $grid->secret('Secret');
        $grid->aes_key('Aes key');
        $grid->created_at('Created at');
        // $grid->updated_at('Updated at');
        $grid->user_id('User id');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(WechatConfig::findOrFail($id));

        $show->id('Id');
        $show->catagory('Catagory');
        $show->name('Name');
        $show->app_id('App id');
        $show->secret('Secret');
        $show->aes_key('Aes key');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        // $show->user_id('User id');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WechatConfig);

        $form->text('catagory', 'Catagory');
        $form->text('name', 'Name');
        $form->text('app_id', 'App id');
        $form->text('secret', 'Secret');
        $form->text('aes_key', 'Aes key');
        // $form->number('user_id', 'User id');

        return $form;
    }
}
