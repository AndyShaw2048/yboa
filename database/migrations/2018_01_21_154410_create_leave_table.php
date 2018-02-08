<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('apply_id');    //申请人ID
            $table->string('apply_department');     //申请人部门
            $table->string('apply_name');           //申请人姓名
            $table->string('apply_contact');        //申请人联系方式
            $table->string('apply_college');     //申请人学院
            $table->string('apply_grade');          //申请人年级
            $table->string('apply_startTime');          //开始时间
            $table->string('apply_endTime');          //结束时间
            $table->string('apply_reason');         //申请理由
            $table->string('accept_opinion')->nullable();       //处理人意见
            $table->unsignedInteger('accept_id')->nullable();   //处理人ID
            $table->string('accept_time')->nullable();          //处理时间
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}
