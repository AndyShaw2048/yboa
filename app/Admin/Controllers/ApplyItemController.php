<?php

namespace App\Admin\Controllers;

use App\ApplyItem;

use App\ApplyItemDetail;
use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ApplyItemController extends Controller
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
            $content->header('易班物资租借系统');
            $content->description('注意：易班物资租借需提前 一周 进行申请');
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
            $content->header('易班物资租借系统');
            $array = ApplyItemDetail::getStatus($id);
            if($array[1]>1)
                $content->body($this->editedForm()->edit($id));
            else
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
            $content->header('易班物资租借系统');
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
        return Admin::grid(ApplyItem::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            if(Admin::user()->isRole('college')){
                $grid->model()->where('apply_id',Admin::user()->id);
                $grid->disableRowSelector();
                $grid->disableExport();
                $grid->disableFilter();
            }
            $grid->id('编号')->sortable();
            $grid->apply_id('申请单位')->display(function($value){
                return User::getRealName($value);
            });
            $grid->apply_item('申请物品');
            $grid->apply_num('申请数量');
            $grid->apply_time('开始时间');
            $grid->return_time('归还时间');
            $grid->apply_contact('联系方式');
            $grid->ApplyItemDetail()->status('状态')->display(function($value){
                $array = explode('|',$value);
                if(isset($array[1])){
                    $r = ApplyItemDetail::getNewestStatus($array[0],$array[1]);
                    if(is_null($r))
                        return '<b style="color: #00a4da">审核中</b>';
                    if($r == '线上审核通过')
                        return '<b style="color: #00a65a">通过</b>|<a href="/uploads/ApplyPrizeDocs/附件6 西华师大易班物资借条.doc" target="_blank">点击下载借条模板</a>';
                    return $r;
                }
            });

            $grid->ApplyItemDetail()->accept_1_note('备注')->display(function($text){
                $less = str_limit($text, 30, '......');
                return "<span title='$text'>$less</span>";
            });
            $grid->actions(function ($actions) {
                $actions->disableDelete();
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
        return Admin::form(ApplyItem::class, function (Form $form) {

            $form->display('id', '编号');
            $form->hidden('apply_id')->default(Admin::user()->id);
            $form->select('apply_item','申请物品')->options([
                                                            '易班熊'=>'易班熊',
                                                            '音响'=>'音响',
                                                            '话筒'=>'话筒',
                                                            '相机'=>'相机',
                                                            '插座'=>'插座',
                                                            '幕布'=>'幕布',
                                                            '投影仪'=>'投影仪',
                                                        ]);
            $form->text('apply_num','申请数量');
            $form->textarea('apply_reason','申请理由');
            $form->mobile('apply_contact','联系方式')->options(['mask' => '999 9999 9999'])->help('主要负责人联系电话');
            $form->datetime('apply_time','借用时间');
            $form->datetime('return_time','归还时间');
            $form->saved(function(Form $form){
                ApplyItemDetail::postApplyItemStatus($form->model()->id);
                return;
            });
        });
    }


    protected function editedForm()
    {
        return Admin::form(ApplyItem::class, function (Form $form) {

            $form->display('id', '编号');
            $form->display('apply_id','申请单位')->with(function($id){
                return User::getRealName($id);
            });
            $form->display('apply_item','申请物品');
            $form->display('apply_num','申请数量');
            $form->display('apply_reason','申请理由');
            $form->display('apply_time','借用时间');
            $form->display('return_time','归还时间');
            $form->display('apply_contact','联系方式');
            $form->disableSubmit();
            $form->disableReset();

        });
    }
}
