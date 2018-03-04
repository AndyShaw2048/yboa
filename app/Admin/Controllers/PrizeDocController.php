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
use App\Http\Controllers\SendMegController;
use Illuminate\Support\MessageBag;

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
            $content->description('注意：活动奖品需于 前一周周日晚18:00前 进行申请');
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
            $content->description('注意：活动奖品需于 前一周周日晚18:00前 进行申请');

            $isEdited = PrizeDoc::getStatus($id);
            $isSumEdited = PrizeDoc::getSumStatus($id);
            if(!is_null($isEdited))
                $content->body($this->editedForm($isEdited,$isSumEdited)->edit($id));
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
            $content->description('注意：活动奖品需于 前一周周日晚18:00前 进行申请');

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
                    return '<span style="color: #00a4da"><b>审核中</b></span>';
                if($r == 1)
                    return '<span style="color: #00a65a"><b>已通过</b></span>';
                elseif($r == 0)
                    return '<span style="color: indianred"><b>已驳回</b></span>';
                else
                    return '<span style="color: indianred">其它结果</span>';
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
                $form->text('activity_name','活动名称')->placeholder('例：xxx学院xxxxx活动');
                $form->mobile('apply_contact','联系方式')->options(['mask'=>'999 9999 9999'])->help('该联系方式用于短信通知');
                $form->file('doc_activity','活动计划书')->move('ApplyPrizeDocs')->uniqueName()->rules('mimes:doc,docx,xlsx')
                    ->help('<a href="'.url('/uploads/ApplyPrizeDocs/附件4 易班学生工作站活动计划书模版.doc').'" target="_blank">点击下载活动计划书模板</a>');
                $form->file('doc_prize','奖品申请表')->move('ApplyPrizeDocs')->uniqueName()->rules('mimes:doc,docx,xlsx')
                     ->help('<a href="'.url('/uploads/ApplyPrizeDocs/附件2 西华师范大学易班学生工作站奖品申请表2017.docx').'" target="_blank">点击下载奖品申请表模板</a>');
                $form->file('doc_summary','活动总结书')->move('ApplyPrizeDocs')->uniqueName()->rules('mimes:doc,docx,xlsx')
                     ->help('<span style="color: red;font-weight: bold">留空，活动结束后请于三日内上传</span>');
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
                    '1' => '通过',
                    '0' => '驳回',
                    '2' => '其他处理结果',
                                                                ]);
                $form->textarea('accept_note','备注');
                $form->hidden('accept_id')->default(Admin::user()->id);
                $form->hidden('accept_time')->default(date('Y-m-d h:i:s',time()));
                $form->hidden('accept_sum_id');
                $form->hidden('accept_sum_opinion');
                $form->hidden('accept_sum_time');
                $form->hidden('accept_sum_note');
                $form->saved(function (Form $form){
                    //发送短信通知
                    $name = User::getRealName($form->model()->apply_id);
                    $tel = str_replace(' ','',$form->model()->apply_contact);
                    $list_id = $form->model()->id;
                    $r = SendMegController::sendMsg('87668',$tel,$name,$list_id);

                    //抛出信息
                    $isFail = $r->result;
                    if(!$isFail){
                        $success = new MessageBag([
                                                      'title'   => '提示',
                                                      'message' => '通知短信发送成功',
                                                  ]);
                        return back()->with(compact('success'));
                    }
                    else{
                        $error = new MessageBag([
                                                    'title'   => '警告',
                                                    'message' => '通知短信发送失败，错误代码为'.$isFail.'，请通知系统管理员进行处理',
                                                ]);

                        return back()->with(compact('error'));
                    }
                });
            }
        });
    }


    //审核后的编辑界面
    protected function editedForm($isEdited,$isSumEdited)
    {
        //审核成功
        if($isEdited == 1){
            if($isSumEdited == 1){
                return Admin::form(PrizeDoc::class, function(Form $form){
                    //学院负责人界面
                    if(Admin::user()->isRole('college')){
                        $form->display('apply_id','申请单位')->with(function($id){
                            return User::getRealName($id);
                        });
                        $form->display('activity_name','活动名称');
                        $form->display('apply_contact','联系方式');
                        $form->display('apply_note','申请备注');
                        $form->display('accept_opinion','审核意见')->with(function($value){
                            switch($value){
                                case 0:return '已驳回';break;
                                case 1:return '已通过';break;
                                case 2:return '其它处理结果';break;
                            }
                        });
                        $form->display('accept_note','审核备注');
                        $form->display('accept_time','审核时间');
                        $form->display('doc_activity','活动计划书')->with(function(){
                            return '<span style="color: #00a157;font-weight: bold">已上传</span>';
                        });
                        $form->display('doc_prize','奖品申请表')->with(function(){
                            return '<span style="color: #00a157;font-weight: bold">已上传</span>';
                        });
                        $form->display('doc_summary','活动总结书')->with(function(){
                            return '<span style="color: #00a157;font-weight: bold">已上传</span>';
                        });
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
                        $form->display('accept_opinion','审核意见')->with(function($value){
                            switch($value){
                                case 0:return '已驳回';break;
                                case 1:return '已通过';break;
                                case 2:return '其它处理结果';break;
                            }
                        });
                        $form->display('accept_note','审核备注');
                        $form->display('accept_time','审核时间');
                        $form->display('accept_sum_id','经办人ID');
                        $form->display('accept_sum_opinion','总结书审核意见')->with(function($value){
                            switch($value){
                                case 0:return '已驳回';break;
                                case 1:return '已通过';break;
                                case 2:return '其它处理结果';break;
                            }
                        });
                        $form->display('accept_sum_note','总结书审核备注');
                        $form->display('accept_sum_time','总结书审核时间');
                    }
                });
            }

            else{
                return Admin::form(PrizeDoc::class, function(Form $form){
                    //学院负责人界面
                    if(Admin::user()->isRole('college')){
                        $form->display('apply_id','申请单位')->with(function($id){
                            return User::getRealName($id);
                        });
                        $form->display('activity_name','活动名称');
                        $form->display('apply_contact','联系方式');
                        $form->display('apply_note','申请备注');
                        $form->display('accept_opinion','审核意见')->with(function($value){
                            switch($value){
                                case 0:return '已驳回';break;
                                case 1:return '已通过';break;
                                case 2:return '其它处理结果';break;
                            }
                        });
                        $form->display('accept_note','审核备注');
                        $form->display('accept_time','审核时间');
                        $form->display('doc_activity','活动计划书')->with(function(){
                            return '<span style="color: #00a157;font-weight: bold">已上传</span>';
                        });
                        $form->display('doc_prize','奖品申请表')->with(function(){
                            return '<span style="color: #00a157;font-weight: bold">已上传</span>';
                        });
                        $form->file('doc_summary','活动总结书')->move('ApplyPrizeDocs')->uniqueName()->rules('mimes:doc,docx,xlsx')
                             ->help('<span style="color: darkred">未通过审核，</span>请重新上传活动总结书');
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
                        $form->display('accept_opinion','审核意见')->with(function($value){
                            switch($value){
                                case 0:return '已驳回';break;
                                case 1:return '已通过';break;
                                case 2:return '其它处理结果';break;
                            }
                        });
                        $form->display('accept_note','审核备注');
                        $form->display('accept_time','审核时间');
                        $form->hidden('accept_sum_id')->default(Admin::user()->id);
                        $form->select('accept_sum_opinion','总结书审核意见')->options([
                                                                                   '1' => '通过',
                                                                                   '0' => '驳回',
                                                                                   '2' => '其他处理结果',
                                                                               ]);
                        $form->textarea('accept_sum_note','总结书审核备注');
                        $form->hidden('accept_sum_time')->default(date('Y-m-d h:i:s',time()+43200));
                    }

                });
            }

            return Admin::form(PrizeDoc::class, function(Form $form){
                //学院负责人界面
                if(Admin::user()->isRole('college')){
                    $form->display('apply_id','申请单位')->with(function($id){
                        return User::getRealName($id);
                    });
                    $form->display('activity_name','活动名称');
                    $form->display('apply_contact','联系方式');
                    $form->display('apply_note','申请备注');
                    $form->display('accept_opinion','审核意见')->with(function($value){
                        switch($value){
                            case 0:return '已驳回';break;
                            case 1:return '已通过';break;
                            case 2:return '其它处理结果';break;
                        }
                    });
                    $form->display('accept_note','审核备注');
                    $form->display('accept_time','审核时间');
                    $form->display('doc_activity','活动计划书')->with(function(){
                        return '<span style="color: #00a157;font-weight: bold">已上传</span>';
                    });
                    $form->display('doc_prize','奖品申请表')->with(function(){
                        return '<span style="color: #00a157;font-weight: bold">已上传</span>';
                    });
                    $form->file('doc_summary','活动总结书')->move('ApplyPrizeDocs')->uniqueName()->rules('mimes:doc,docx,xlsx')
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
                    $form->display('accept_opinion','审核意见')->with(function($value){
                        switch($value){
                            case 0:return '已驳回';break;
                            case 1:return '已通过';break;
                            case 2:return '其它处理结果';break;
                        }
                    });
                    $form->display('accept_note','审核备注');
                    $form->display('accept_time','审核时间');
                    $form->hidden('accept_sum_id')->default(Admin::user()->id);
                    $form->select('accept_sum_opinion','总结书审核意见')->options([
                            '1' => '通过',
                            '0' => '驳回',
                            '2' => '其他处理结果',
                                                                        ]);
                    $form->textarea('accept_sum_note','总结书审核备注');
                    $form->hidden('accept_sum_time')->default(date('Y-m-d h:i:s',time()+43200));
                }

            });
        }

        //审核失败
        else
        {
            return Admin::form(PrizeDoc::class, function(Form $form){
                if(Admin::user()->isRole('college')){
                    $form->display('apply_id','申请单位')->with(function($id){
                        return User::getRealName($id);
                    });
                    $form->display('activity_name','活动名称');
                    $form->display('apply_contact','联系方式');
                    $form->display('apply_note','申请备注');
                    $form->display('accept_opinion','审核意见')->with(function($value){
                        switch($value){
                            case 0:return '已驳回';break;
                            case 1:return '已通过';break;
                            case 2:return '其它处理结果';break;
                        }
                    });
                    $form->display('accept_note','审核备注');
                    $form->display('accept_time','审核时间');
                    $form->display('doc_activity','活动计划书')->with(function(){
                        return '<span style="color: #00a157;font-weight: bold">已上传</span>';
                    });
                    $form->display('doc_prize','奖品申请表')->with(function(){
                        return '<span style="color: #00a157;font-weight: bold">已上传</span>';
                    });
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
                        $form->display('accept_opinion','审核意见')->with(function($value){
                            switch($value){
                                case 0:return '已驳回';break;
                                case 1:return '已通过';break;
                                case 2:return '其它处理结果';break;
                            }
                        });
                        $form->display('accept_note','审核备注');
                        $form->display('accept_time','审核时间');
                }
                $form->disableSubmit();
                $form->disableReset();
            });
        }



    }
}
