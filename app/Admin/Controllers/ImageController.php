<?php

namespace App\Admin\Controllers;

use App\Image;

use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ImageController extends Controller
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

            $content->header('我与易班合个影');
            $content->description('列表');

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

            $content->header('我与易班合个影');
            $content->description('编辑');

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

            $content->header('我与易班合个影');
            $content->description('新增');

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
        return Admin::grid(Image::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->student_id('考生号')->sortable();
            $grid->number('照片编号')->sortable();
            $grid->type('校区')->sortable()->display(function($v){
                return $v == 1 ? '新区' : '老区';
            });
            $grid->user_id('录入人')->display(function($v){
                return User::getRealName($v);
            });
            $grid->created_at('创建于');

            $grid->filter(function($filter){

                // 去掉默认的id过滤器
                $filter->disableIdFilter();

                // 在这里添加字段过滤器
                $filter->like('student_id', '考生号');
                $filter->like('number', '照片编号');

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
        return Admin::form(Image::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('type','校区')->options(['1'=>'新区','2'=>'老区']);
            $form->text('number','照片编号');
            $form->text('student_id','考生号');
            $form->hidden('user_id')->value(Admin::user()->id);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
