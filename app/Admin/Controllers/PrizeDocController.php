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
            $content->header('活动奖品申请系统');
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
            $content->header('活动奖品申请系统');
            $isEdited = PrizeDoc::getStatus($id);
            if($isEdited)
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
            $content->header('活动奖品申请系统');
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
            if(Admin::user()->isRole('college')){
                $grid->model()->where('apply_id',Admin::user()->id);
                $grid->disableExport();
                $grid->disableFilter();
                $grid->disableRowSelector();
                $grid->actions(function ($actions) {
                    $actions->disableDelete();
                });
            }
            else{
                $grid->disableCreateButton();
            }
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
            $grid->doc_summary('活动总结书')->display(function($value){
                if(is_null($value))
                    return '未上传';
                $value = url('uploads/'.$value);
                return "<a href='$value' target='_blank'>点击下载</a>";
            });;
            $grid->apply_time('申请时间');
            $grid->accept_opinion('审核意见')->display(function($r){
                if(is_null($r))
                    return '审核中';
                if($r == '审核通过')
                    return '<span style="color: #00a65a">审核通过</span>';
                else
                    return '<span style="color: indianred">'.$r.'</span>';
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
            //学院负责人界面
            if(Admin::user()->isRole('college'))
            {
                $form->hidden('apply_id')->default(Admin::user()->id);
                $form->text('activity_name','活动名称');
                $form->mobile('apply_contact','联系方式')->options(['mask'=>'999 9999 9999']);
                $form->file('doc_activity','活动计划书')->move('ApplyPrizeDocs')->uniqueName()
                    ->help('<a href="'.url('/uploads/ApplyPrizeDocs/附件4 易班学生工作站活动计划书模版.doc').'" target="_blank">点击下载活动计划书模板</a>');
                $form->file('doc_prize','奖品申请表')->move('ApplyPrizeDocs')->uniqueName()
                     ->help('<a href="'.url('/uploads/ApplyPrizeDocs/附件2 西华师范大学易班学生工作站奖品申请表2017.docx').'" target="_blank">点击下载奖品申请表模板</a>');
                $form->hidden('doc_summary');
                $form->hidden('apply_time')->default(date("Y-m-d h:i:s",time()));
                $form->textarea('apply_note','备注');
            }


            //管理员审核界面
            if(Admin::user()->isRole('administrator'))
            {
                $form->display('apply_id','申请单位')->with(function($id){
                   return User::getRealName($id);
                });
                $form->display('activity_name','活动名称');
                $form->display('apply_note','申请备注');
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


    //审核后的编辑界面
    protected function editedForm()
    {
        return Admin::form(PrizeDoc::class, function (Form $form) {
            //学院负责人界面
            if(Admin::user()->isRole('college'))
            {
                $form->display('apply_id','申请单位')->with(function($id){
                    return User::getRealName($id);
                });
                $form->display('activity_name','活动名称');
                $form->display('apply_contact','联系方式');
                $form->display('apply_note','申请备注');
                $form->display('accept_opinion','审核意见');
                $form->display('accept_note','审核备注');
                $form->display('accept_time','审核时间');
                $form->file('doc_summary','活动总结书')->move('ApplyPrizeDocs')->uniqueName()
                     ->help('<a href="'.url('/uploads/ApplyPrizeDocs/附件5 易班学生工作站总结书模版.doc').'" target="_blank">点击下载活动总结书模板</a>');

            }


            //管理员审核界面
            if(Admin::user()->isRole('administrator'))
            {
                $form->display('apply_id','申请单位')->with(function($id){
                    return User::getRealName($id);
                });;
                $form->display('activity_name','活动名称');
                $form->display('apply_contact','联系方式');
                $form->display('apply_note','申请备注');
                $form->display('accept_id','经办人')->with(function($value){
                    return User::getRealName($value);
                });
                $form->display('accept_opinion','审核意见');
                $form->display('accept_note','审核备注');
                $form->display('accept_time','审核时间');
                $form->disableSubmit();
                $form->disableReset();
            }
        });
    }
}
