<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\ApiController;
use App\Inventory;
use App\ItemDetail;
use App\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;


class ItemDetailController extends Controller
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
            $content->header('仓库操作详细记录');
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
            $content->header('仓库操作详细记录');
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
            $content->header('仓库操作详细记录');
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
        return Admin::grid(ItemDetail::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->id('流水号')->sortable();
            $grid->item_id('物品名称')->display(function($value){
                $inventory = ApiController::getInventoryList();
                foreach ($inventory as $item) {
                    if($value == $item['id'])return $item['text'];
                }
            });
            $grid->before('原始数量');
            $grid->changed('改变数量');
            $grid->after('最终数量');
            $grid->operate_id('操作人')->display(function($value){
                return User::getRealName($value);
            });
            $grid->operate_reason('操作理由');
            $grid->operate_time('操作时间');

            $grid->disableActions();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ItemDetail::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('item_id','物品名称')->options('/api/inventory');
            $form->number('changed','改变数量');

            $form->hidden('before')->default(0);
            $form->hidden('operate_id')->default(Admin::user()->id);
            $form->textarea('operate_reason','操作理由');
            $form->hidden('operate_time')->default(date("Y-m-d H:i:s",time()));
            $form->hidden('after')->default(0);

            //实现两表同时更新
            $form->saved(function(Form $form){
                $before = Inventory::getBefore($form->model()->item_id);
                $after = $before + $form->model()->changed;
                ItemDetail::updateBefore($form->model()->id,$before);
                Inventory::updateStocks($form->item_id,$after);
                ItemDetail::updateAfter($form->model()->id,$after);
            });
        });
    }

}
