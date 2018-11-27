<?php

namespace App\Admin\Controllers;

use App\Post;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PostController extends Controller
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
            ->header(trans('admin.Index'))
            ->description('文章'.trans('admin.Index'))
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
            ->header(trans('admin.Detail'))
            ->description('文章'.trans('admin.Detail'))
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
            ->header(trans('admin.Edit'))
            ->description(trans('admin.Edit').'文章')
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
            ->header(trans('admin.Create'))
            ->description(trans('admin.Create').'文章')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Post);

        $grid->id('序号');
        $grid->title('Title');
        $grid->summary('Summary');
        $grid->body('Body');
        $grid->user_id('User id');
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');
        $grid->ispublish('Ispublish');

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
        $show = new Show(Post::findOrFail($id));

        $show->id('序号');
        $show->title('Title');
        $show->summary('Summary');
        $show->body('Body');
        $show->user_id('User id');
        $show->created_at('创建时间');
        $show->updated_at('更新时间');
        $show->ispublish('Ispublish');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Post);

        $form->text('title', 'Title');
        $form->text('summary', 'Summary');
        $form->textarea('body', 'Body');
        $form->number('user_id', 'User id')->default(1);
        $form->switch('ispublish', 'Ispublish');

        return $form;
    }
}
