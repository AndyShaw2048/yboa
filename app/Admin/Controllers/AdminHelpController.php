<?php

namespace App\Admin\Controllers;

use App\Help;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class AdminHelpController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('帮助文档-预览');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('帮助文档-编辑');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('帮助文档-创建');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Help::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->title('标题')->editable('text');
            $grid->parent_id('父ID')->editable();
            $grid->content('内容')->display(function($value){
                $value = htmlspecialchars($value);
                return str_limit($value,30,'...');
            });
            $grid->updated_at('更新时间');


            $grid->filter(function($filter){
                $filter->equal('parent_id','父级菜单');

            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Help::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('title','标题');
            $form->text('parent_id','父级菜单ID');
            $form->editor('content');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
