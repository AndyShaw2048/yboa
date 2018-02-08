<?php

namespace App\Admin\Controllers;

use App\PrizeDoc;

use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class PrizeDocController extends Controller
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

            $content->header('奖品申请审核系统');
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
        return Admin::grid(PrizeDoc::class, function (Grid $grid) {
            if(Admin::user()->isRole('college'))
                $grid->model()->where('apply_id',Admin::user()->id);
            $grid->id('编号');
            $grid->apply_id('申请单位')->display(function($id){
                   return User::getRealName($id);
                });;
            $grid->apply_contact('联系电话');
            $grid->activity_name('活动名称');
            $grid->doc_activity('活动计划书')->display(function($value){
                $value = url('uploads/'.$value);
                return "<a href='$value' target='_blank'>点击下载</a>";
            });
            $grid->doc_prize('奖品申请表')->display(function($value){
                $value = url('uploads/'.$value);
                return "<a href='$value' target='_blank'>点击下载</a>";
            });;
            $grid->apply_time('申请时间');
            $grid->accept_opinion('审核意见')->display(function($value){
                $r = is_null($value) ? '审核中' :  $value;
                return $r;
            });
            $grid->accept_note('备注');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(PrizeDoc::class, function (Form $form) {
            if(Admin::user()->isRole('college'))
            {
                $form->display('id', 'ID');
                $form->hidden('apply_id')->default(Admin::user()->id);
                $form->text('activity_name','活动名称');
                $form->mobile('apply_contact','联系方式');
                $form->file('doc_activity','活动计划书')->move('ApplyPrizeDocs')->uniqueName();
                $form->file('doc_prize','奖品申请表')->move('ApplyPrizeDocs')->uniqueName();
                $form->hidden('apply_time')->default(date("Y-m-d h:i:s",time()));
                $form->textarea('apply_note','备注');
                $form->display('created_at', 'Created At');
                $form->display('updated_at', 'Updated At');
            }
            if(Admin::user()->isRole('administrator'))
            {
                $form->display('apply_id','申请单位')->with(function($id){
                   return User::getRealName($id);
                });
                $form->display('activity_name','活动名称');
                $form->select('accept_opinion','审核意见')->options([
                    '审核通过' => '审核通过',
                    '审核通过失败' => '审核通过失败',
                    '其他处理结果' => '其他处理结果',
                                                                ]);
                $form->textarea('accept_note','备注');
                $form->hidden('accept_id')->default(Admin::user()->id);
                $form->hidden('accept_time')->default(date('Y-m-d h:i:s',time()));
            }
        });
    }
}
