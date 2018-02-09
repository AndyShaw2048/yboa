<?php

namespace App\Admin\Controllers;

use App\ApplyRole;

use App\Role;
use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\MessageBag;

class ApplyroleController extends Controller
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
            $content->header('申请认证');
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
            $content->header('申请认证');
            $isAdmin = Admin::user()->isRole('administrator','manager');
            if($isAdmin)
            {
                $content->body($this->editedAdminForm()->edit($id));
            }
            else
            {
                $isEditedFresher = applyRole::wherenull('accept_opinion')->get();
                if($isEditedFresher){
                    $content->body($this->editedFresherForm()->edit($id));
                    return;
                }
                $content->body($this->form()->edit($id));
            }

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
            $content->header('申请认证');
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
        return Admin::grid(applyRole::class, function (Grid $grid) {

            $grid->id('编号');
            $grid->apply_id('认证账号')->display(function($id){
                return User::getRealName($id);
            });
            $grid->apply_role('认证角色')->display(function($apply_role){
                switch($apply_role){
                    case 2:return '管理员';
                    case 3:return '部长';
                    case 4:return '部门干事';
                    case 5:return '学院官方账号';
                }
            });
            $grid->apply_reason('认证理由');
            $grid->accept_opinion('审核结果')->display(function($value){
                switch($value){
                    case '审核成功': return '<b style="color: #00a157">审核通过</b>';
                    case '审核通过失败': return '<b style="color: #d5432b">审核未通过</b>';
                    case '其他处理结果': return '<b style="color: #d5be28">审核暂停</b>';
                    default:return '<b style="color: #2dc5ea">审核中</b>';
                }
            });

            $isFresher = Admin::user()->isRole('fresher');
            if($isFresher){
                $grid->model()->where('apply_id',Admin::user()->id);
                $grid->disableFilter();
                $grid->disableExport();
            }
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->disableRowSelector();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(applyRole::class, function (Form $form) {
            $form->display('apply_id','认证账号')->value(User::getRealName(Admin::user()->id));
            $form->hidden('apply_id')->default(Admin::user()->id);
            $roles = [
                2 => '管理员',
                3 => '部长',
                4 => '干事',
                5 => '学院官方账号'
            ];
            $form->select('apply_role','认证角色')->options($roles)
                 ->help('请如实选择身份，否则将认证失败！')->rules('required',[
                    'required' => '请选择您要认证的角色'
                ]);
            $form->textarea('apply_reason','认证说明')->rules('required',[
                'required' => '请填写认证说明',
            ]);
            $form->hidden('accept_opinion');
            $form->hidden('accept_time');

            $form->saved(function ($form) {
                $opinion = $form->model()->accept_opinion;
                $userid = $form->model()->apply_id;
                $role = $form->model()->apply_role;
                if($opinion == '审核成功'){
                    $r = Role::editRoles($userid,$role);
                    if(!$r){
                        $error = new MessageBag([
                                     'message' => '写入数据库时失败,请联系网站管理员',
                                                ]);
                        return back()->with(compact('error'));
                    }
                }
            });
        });
    }

    //管理员审核用户组申请界面
    protected function editedAdminForm()
    {
        return Admin::form(applyRole::class, function (Form $form) {

            $form->display('apply_id','认证ID');
            $form->display('apply_role','认证角色')->with(function($value){
                switch($value){
                    case 2:return '管理员';
                    case 3:return '部长';
                    case 4:return '部门干事';
                    case 5:return '学院官方账号';
                }
            });
            $form->display('apply_reason','认证理由');
            $form->select('accept_opinion','审核结果')->options([
                '审核成功' => '审核成功',
                '审核通过失败' => '审核通过失败',
                '其他处理结果' => '其他处理结果',
            ]);

            $form->hidden('accept_time')->default(date("Y-m-d h:m:s",time()));

        });
    }


    //未认证用户只读认证信息
    protected function editedFresherForm()
    {
        return Admin::form(applyRole::class, function (Form $form) {
            $form->display('apply_id','认证ID');
            $form->display('apply_role','认证角色')->with(function($value){
                switch($value){
                    case 2:return '管理员';
                    case 3:return '部长';
                    case 4:return '部门干事';
                    case 5:return '学院官方账号';
                }
            });
            $form->display('created_at','申请时间');
            $form->disableSubmit();

        });
    }
}
