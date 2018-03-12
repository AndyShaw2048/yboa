<?php

namespace App\Admin\Controllers;

use App\Leave;

use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\MessageBag;

class LeaveController extends Controller
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
            $content->header('请假系统');
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

            $content->header('请假系统');

            //判断用户权限
            $isRoles = Admin::user()->inRoles(['officer', 'minister','manager']);
            if(!$isRoles){
                $content->body('您没有审核权限！');
                return;
            }

            //该假条是否已被部长审核，审核过则无法修改
            $isEdited = Leave::where('id',$id)
                               ->wherenull('accept_opinion')
                               ->first();

            if($isEdited) $content->body($this->form()->edit($id));
            else $content->body($this->editedForm()->edit($id));
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
            $content->header('新建假条');
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
        return Admin::grid(Leave::class, function (Grid $grid) {

            //干事界面
            $isOfficer = Admin::user()->isRole('officer');
            if($isOfficer)
            {
                $grid->model()->where('apply_id',Admin::user()->id);
                $grid->id('编号')->sortable();
                $grid->apply_name('申请人');
                $grid->apply_contact('联系方式');
                $grid->apply_department('部门')->display(function ($apply_department){
                    switch($apply_department){
                        case 1:return '技术部';
                        case 2:return '办公室';
                        case 3:return '新闻部';
                        case 4:return '宣传部';
                        default:return '非法部门';
                    }
                });
                $grid->apply_college('学院');
                $grid->apply_grade('年级');
                $grid->column('请假时间')->display(function () {
                    return $this->apply_startTime.'<br>'.$this->apply_endTime;
                });
                $grid->apply_reason('请假理由');
                $grid->accept_opinion('部长意见')->display(function($value){
                    if(is_null($value)){
                        return '<span style="color: #00a7d0;font-weight: bold">待审核</span>';
                    }
                    if($value == '批准') return '<span style="color: #00a157;font-weight: bold">批准</span>';
                    else return '<span style="color: #c73300;font-weight: bold">驳回</span>';
                });
                $grid->accept_time('处理时间');


                $grid->actions(function ($actions) {
                    $actions->disableDelete();
                });
                $grid->disableRowSelector();
                $grid->disableExport();
                $grid->disableFilter();
            }

            //网站管理员界面
            elseif(Admin::user()->inRoles(['administrator,manager'])){
                $grid->model()->wherenotnull('accept_id');
                $grid->id('编号')->sortable();
                $grid->apply_name('申请人');
                $grid->apply_contact('联系方式');
                $grid->apply_department('部门')->display(function ($apply_department){
                    switch($apply_department){
                        case 1:return '技术部';
                        case 2:return '办公室';
                        case 3:return '新闻部';
                        case 4:return '宣传部';
                        default:return '非法部门';
                    }
                });
                $grid->apply_college('学院');
                $grid->apply_grade('年级');
                $grid->column('请假时间')->display(function () {
                    return $this->apply_startTime.'<br>'.$this->apply_endTime;
                });
                $grid->apply_reason('请假理由');
                $grid->accept_opinion('部长意见');
                $grid->accept_time('处理时间');


                $grid->disableCreateButton();
                $grid->actions(function ($actions) {
                    $actions->disableDelete();
                });
                $grid->tools(function ($tools) {
                    $tools->batch(function ($batch) {
                        $batch->disableDelete();
                    });
                });
            }

            //部长界面
            else
            {
                $grid->model()->where('apply_department',User::department());
                $grid->id('编号')->sortable();
                $grid->apply_name('申请人');
                $grid->apply_contact('联系方式');
                $grid->apply_department('部门')->display(function ($apply_department){
                    switch($apply_department){
                        case 1:return '技术部';
                        case 2:return '办公室';
                        case 3:return '新闻部';
                        case 4:return '宣传部';
                        default:return '非法部门';
                    }
                });
                $grid->apply_college('学院');
                $grid->apply_grade('年级');
                $grid->column('请假时间')->display(function () {
                    return $this->apply_startTime.'<br>'.$this->apply_endTime;
                });
                $grid->apply_reason('请假理由');
                $grid->accept_opinion('部长意见');
                $grid->accept_time('处理时间');


                $grid->disableCreateButton();
                $grid->actions(function ($actions) {
                    $actions->disableDelete();
                });
                $grid->tools(function ($tools) {
                    $tools->batch(function ($batch) {
                        $batch->disableDelete();
                    });
                });
            }

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {

        return Admin::form(Leave::class, function (Form $form) {
            //干事界面
            $isOfficer = Admin::user()->isRole('officer');
            if($isOfficer){
                $form->display('id', '编号');
                $form->hidden('apply_id')->value(Admin::user()->id);
                $form->hidden('apply_department')->value(User::department());
                $form->hidden('apply_name')->value(User::realname());
                $form->display('apply_name','申请人姓名')->value(User::realname());
                $form->mobile('apply_contact','联系方式')->options(['mask' => '999 9999 9999']);
                $college = [
                    '政治与行政学院' => '政治与行政学院',
                    '音乐学院' => '音乐学院',
                    '学前与初等教育学院' => '学前与初等教育学院',
                    '新闻传播学院' => '新闻传播学院',
                    '物空学院' => '物空学院',
                    '文学院' => '文学院',
                    '外国语学院' => '外国语学院',
                    '体育学院' => '体育学院',
                    '数学与信息学院' => '数学与信息学院',
                    '生命科学学院' => '生命科学学院',
                    '商学院' => '商学院',
                    '美术学院' => '美术学院',
                    '历史文化学院' => '历史文化学院',
                    '教育学院' => '教育学院',
                    '计算机学院' => '计算机学院',
                    '环境科学与工程学院' => '环境科学与工程学院',
                    '国土资源学院' => '国土资源学院',
                    '管理学院' => '管理学院',
                    '高等职业技术学院' => '高等职业技术学院',
                    '法学院' => '法学院',
                    '电子信息工程学院' => '电子信息工程学院',
                    '化学化工学院' => '化学化工学院',
                ];
                $form->select('apply_college','学院')->options($college)->rules('required',[
                    'required' => '学院禁止为空',
                ]);;
                $department = [
                    '2017级' => '2017级',
                    '2016级' => '2016级',
                    '2015级' => '2015级',
                    '2014级' => '2014级',
                ];
                $form->select('apply_grade','年级')->options($department)->rules('required',[
                    'required' => '年级禁止为空',
                ]);;
                $form->datetimeRange('apply_startTime', 'apply_endTime', '请假时间')->rules('required',[
                    'required' => '请假时间禁止为空',
                ]);;
                $form->textarea('apply_reason','请假理由')->rules('required',[
                    'required' => '请假理由禁止为空',
                ]);;

                $form->saving(function (Form $form){
                    if(is_null($form->apply_department)){
                        $error = new MessageBag([
                                                    'title'   => '错误信息',
                                                    'message' => '请先选择自己的所属部门，<a href="'.url('admin/auth/setting').'">点击前往设置</a>',
                                                ]);

                        return back()->with(compact('error'));
                    }

                });
            }


            //管理员界面
            $isMinister = Admin::user()->isRole('minister');
            if($isMinister){
                $form->display('id');
                $form->display('apply_name','请假人');
                $form->display('apply_reason','请假理由');
                $form->display('请假时间')->with(function () {
                    return $this->apply_startTime.' - '.$this->apply_endTime;
                });
                $form->select('accept_opinion','审核意见')->options([
                    '批准' => '批准',
                    '驳回' => '驳回'
                                                                ]);
                $form->hidden('accept_id')->default(Admin::user()->id);
                $form->hidden('accept_time')->default(date("Y-m-d H:i:s",time()));

            }
        });
    }


protected function editedForm()
{
    return Admin::form(Leave::class, function (Form $form) {
        //干事新增后、部长审核前的干事界面
        $isOfficer = Admin::user()->isRole('officer');
        if($isOfficer){
            $form->display('id', 'ID');
            $form->hidden('apply_id')->value('8562961');
            $form->hidden('apply_department')->value('1');
            $form->display('apply_name','姓名');
            $form->display('apply_contact','联系方式');
            $form->display('apply_college','学院');
            $form->display('apply_grade','年级');
            $form->display('请假时间')->with(function () {
                return $this->apply_startTime.' - '.$this->apply_endTime;
            });
            $form->display('apply_reason','请假理由');
            $form->disableSubmit();
            $form->disableReset();
        }

        //管理员审核后的显示界面
        $isMinister = Admin::user()->isRole('minister');
        if($isMinister){
            $userid = Admin::user()->id;
            $form->display('id','编号');
            $form->display('apply_name','请假人');
            $form->display('apply_reason','请假理由');
            $form->display('accept_opinion','处理意见');
            $form->hidden('accept_id')->default($userid);
            $form->hidden('accept_time')->default(date("Y-m-d H:i:s",time()));
        }
        elseif(Admin::user()->isRole('manager')){
            $form->display('id','编号');
            $form->display('apply_name','请假人');
            $form->display('apply_reason','请假理由');
            $form->display('请假时间')->with(function () {
                return $this->apply_startTime.' - '.$this->apply_endTime;
            });
            $form->select('accept_opinion','审核意见')->options([
                                                                '批准' => '批准',
                                                                '驳回' => '驳回'
                                                            ]);
            $form->hidden('accept_id')->default(Admin::user()->id);
            $form->hidden('accept_time')->default(date("Y-m-d H:i:s",time()));
        }

    });
}
}
