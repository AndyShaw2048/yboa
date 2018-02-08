<?php

namespace App\Admin\Controllers;

use App\Inventory;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class InventoryController extends Controller
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

            $content->header('header');
            $content->description('description');

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

            $content->header('header');
            $content->description('description');

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

            $content->header('header');
            $content->description('description');

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
        return Admin::grid(Inventory::class, function (Grid $grid) {

            $grid->id('编号');
            $grid->name('名称');
            $grid->image('图片')->display(function($value){
                return '<img src='.url("uploads/".$value).' style="width:200px;">';
            });
            $grid->stocks('库存量');

//            $grid->created_at();
//            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Inventory::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name','物品名称');
            $form->text('description','物品描述');
//            $form->text('image','物品照片');

            // 修改上传目录
            $form->image('image')->move('inventoryImages')->uniqueName();
            $form->number('stocks','物品数量');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
