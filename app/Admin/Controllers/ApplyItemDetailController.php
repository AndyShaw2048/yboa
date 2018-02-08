<?php

namespace App\Admin\Controllers;

use App\ApplyItemDetail;

use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ApplyItemDetailController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    private $status = null;

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('易班物资租借审核系统');
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
            $content->header('易班物资租借审核系统');
            $content->description('注意：审核之前，请认真查看之前是否已通过审核！');
            $array = ApplyItemDetail::getStatusOnId($id);
            $content->body($this->editedForm($array)->edit($id));
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
            $content->header('易班物资租借审核系统');
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
        return Admin::grid(ApplyItemDetail::class, function (Grid $grid) {

            $grid->apply_item_id('编号')->sortable();
            $grid->ApplyItem()->apply_id('申请单位')->display(function ($value) {
                return User::getRealName($value);
            });
            $grid->column('ApplyItem.apply_item', '物品名称');
            $grid->column('ApplyItem.apply_num', '物品数量');
            $grid->column('ApplyItem.apply_reason', '申请原因')->display(function ($text) {
                $less = str_limit($text, 30, '......');
                return "<span title='$text'>$less</span>";
            });;
            $grid->column('ApplyItem.apply_contact', '联系电话');
            $grid->column('ApplyItem.apply_time', '开始时间');
            $grid->column('ApplyItem.return_time', '结束时间');
            $grid->status('状态')->display(function($value){
                $array = explode('|',$value);
                if($array[1] == 5){
                    return '<span style="color: #00a65a">已完成</span>';
                }
                else
                    return '<span style="color: #c78607">审核中 | 第'.$array[1].'环节</span>';
            });
            $grid->disableCreateButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ApplyItemDetail::class, function (Form $form) {
            $form->text('accept_1_id');
            $form->text('accept_1_opn');
            $form->text('accept_1_note');
            $form->text('accept_1_time');
            $form->text('accept_2_id');
            $form->text('accept_2_opn');
            $form->text('accept_2_note');
            $form->text('accept_2_time');
            $form->text('accept_3_id');
            $form->text('accept_3_opn');
            $form->text('accept_3_note');
            $form->text('accept_3_time');
            $form->text('accept_4_id');
            $form->text('accept_4_opn');
            $form->text('accept_4_note');
            $form->text('accept_4_time');
            $form->saved(function (Form $form) {
                $array_o = $form->model()->status;
                $array_o = explode('|', $array_o);
                $string = $array_o[0] . '|' . ($array_o[1] + 1);
                ApplyItemDetail::updateStatus($array_o[0], $string);
                return;
            });
        });
    }


    protected function editedForm($array)
    {

        if ( $array[1] == 1 ) {
            return Admin::form(ApplyItemDetail::class, function (Form $form) {
                $form->tab('线上审核', function ($form) {
                    $form->hidden('accept_1_id')->default(Admin::user()->id);
                    $form->display('accept_1_id', '经办人')->default(User::realname());
                    $form->select('accept_1_opn', '审核意见')->options([
                                                                       '线上审核通过' => '线上审核通过',
                                                                       '线上审核失败' => '线上审核失败',
                                                                       '其他处理结果' => '其他处理结果',
                                                                   ]);
                    $form->textarea('accept_1_note', '备注');
                    $form->hidden('accept_1_time')->default(date("Y-m-d h:i:s", time() + 26800));
                });

            });
        }
        if ( $array[1] == 2 ) {
            return Admin::form(ApplyItemDetail::class, function (Form $form) {
                $form->tab('线上审核', function ($form) {
                    $form->display('accept_1_id', '经办人')->with(function ($value) {
                        return User::getRealName($value);
                    });
                    $form->display('accept_1_opn', '审核意见');
                    $form->display('accept_1_time', '审核时间');
                    $form->display('accept_1_note', '备注');
                })->tab('领取物品', function ($form) {
                    $form->hidden('accept_2_id')->default(Admin::user()->id);
                    $form->display('accept_2_id', '经办人')->default(User::realname());
                    $form->select('accept_2_opn', '审核意见')->options([
                                                                       '物品已领取' => '物品已领取',
                                                                       '物品逾期未领' => '物品逾期未领',
                                                                       '其他处理结果' => '其他处理结果',
                                                                   ]);
                    $form->textarea('accept_2_note', '备注');
                    $form->hidden('accept_2_time')->default(date("Y-m-d h:i:s", time() + 26800));
                });
            });
        }
        if ( $array[1] == 3 ) {
            return Admin::form(ApplyItemDetail::class, function (Form $form) {
                $form->tab('线上审核', function ($form) {
                    $form->display('accept_1_id', '经办人')->with(function ($value) {
                        return User::getRealName($value);
                    });
                    $form->display('accept_1_opn', '审核意见');
                    $form->display('accept_1_time', '审核时间');
                    $form->display('accept_1_note', '备注');
                })->tab('领取物品', function ($form) {
                    $form->display('accept_2_id', '经办人')->with(function ($value) {
                        return User::getRealName($value);
                    });
                    $form->display('accept_2_opn', '审核意见');
                    $form->display('accept_2_time', '审核时间');
                    $form->display('accept_2_note', '备注');
                })->tab('活动审核', function ($form) {
                    $form->hidden('accept_3_id')->default(Admin::user()->id);
                    $form->display('accept_3_id', '经办人')->default(User::realname());
                    $form->select('accept_3_opn', '审核意见')->options([
                                                                       '活动合格' => '活动合格',
                                                                       '活动不合格' => '活动不合格',
                                                                       '其他处理结果' => '其他处理结果',
                                                                   ]);
                    $form->textarea('accept_3_note', '备注');
                    $form->hidden('accept_3_time')->default(date("Y-m-d h:i:s", time() + 26800));
                });
            });
        }
        if ( $array[1] == 4 ) {
            return Admin::form(ApplyItemDetail::class, function (Form $form) {
                $form->tab('线上审核', function ($form) {
                    $form->display('accept_1_id', '经办人')->with(function ($value) {
                        return User::getRealName($value);
                    });
                    $form->display('accept_1_opn', '审核意见');
                    $form->display('accept_1_time', '审核时间');
                    $form->display('accept_1_note', '备注');
                })->tab('领取物品', function ($form) {
                    $form->display('accept_2_id', '经办人')->with(function ($value) {
                        return User::getRealName($value);
                    });
                    $form->display('accept_2_opn', '审核意见');
                    $form->display('accept_2_time', '审核时间');
                    $form->display('accept_2_note', '备注');
                })->tab('活动审核', function ($form) {
                    $form->display('accept_3_id', '经办人')->with(function ($value) {
                        return User::getRealName($value);
                    });
                    $form->display('accept_3_opn', '审核意见');
                    $form->display('accept_3_time', '审核时间');
                    $form->display('accept_3_note', '备注');
                })->tab('物品归还', function ($form) {
                    $form->hidden('accept_4_id')->default(Admin::user()->id);
                    $form->display('accept_4_id', '经办人')->default(User::realname());
                    $form->select('accept_4_opn', '审核意见')->options([
                                                                       '物品已归还、无损坏' => '物品已归还、无损坏',
                                                                       '物品已归还、有损坏' => '物品已归还、有损坏',
                                                                       '物品未及时归还' => '物品未及时归还',
                                                                       '物品未归还' => '物品未归还',
                                                                       '其他处理结果' => '其他处理结果',
                                                                   ]);
                    $form->textarea('accept_4_note', '备注');
                    $form->hidden('accept_4_time')->default(date("Y-m-d h:i:s", time() + 26800));
                });
            });

        }

        if ( $array[1] == 5 ) {
            return Admin::form(ApplyItemDetail::class, function (Form $form) {
                $form->tab('线上审核', function ($form) {
                    $form->display('accept_1_id', '经办人')->with(function ($value) {
                        return User::getRealName($value);
                    });
                    $form->display('accept_1_opn', '审核意见');
                    $form->display('accept_1_time', '审核时间');
                    $form->display('accept_1_note', '备注');
                })->tab('领取物品', function ($form) {
                    $form->display('accept_2_id', '经办人')->with(function ($value) {
                        return User::getRealName($value);
                    });
                    $form->display('accept_2_opn', '审核意见');
                    $form->display('accept_2_time', '审核时间');
                    $form->display('accept_2_note', '备注');
                })->tab('活动审核', function ($form) {
                    $form->display('accept_3_id', '经办人')->with(function ($value) {
                        return User::getRealName($value);
                    });
                    $form->display('accept_3_opn', '审核意见');
                    $form->display('accept_3_time', '审核时间');
                    $form->display('accept_3_note', '备注');
                })->tab('物品归还', function ($form) {
                    $form->display('accept_4_id', '经办人')->with(function ($value) {
                        return User::getRealName($value);
                    });
                    $form->display('accept_4_opn', '审核意见');
                    $form->display('accept_4_time', '审核时间');
                    $form->display('accept_4_note', '备注');
                });
            });

            if ( $array[1] == 0 ) {
                return Admin::form(ApplyItemDetail::class, function (Form $form) {
                    $form->display('','本物品租借已被终止');
                });

            }

        }
    }
}
