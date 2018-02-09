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
            $content->header('物品库存');
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
            $content->header('物品库存');
            $content->body($this->editedForm()->edit($id));
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
            $content->header('物品库存');
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
            $grid->image('照片')->image('http://oa.com/uploads/',50,50);
            $grid->stocks('库存量');
            $grid->description('物品描述');
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
            $form->text('name','物品名称');
            $form->textarea('description','物品描述');

            // 修改上传目录
            $form->image('image')->move('inventoryImages')->uniqueName();
            if(!isset($id))
                $form->number('stocks','物品数量');
            else
                $form->display('stocks','物品数量');

        });
    }

    protected function editedForm()
    {
        return Admin::form(Inventory::class, function (Form $form) {
            $form->text('name','物品名称');
            $form->textarea('description','物品描述');

            // 修改上传目录
            $form->image('image')->move('inventoryImages')->uniqueName();
            $form->display('stocks','物品数量');

        });
    }
}
