<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplyItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('apply_id');
            $table->unsignedInteger('apply_item');
            $table->unsignedInteger('apply_num');
            $table->string('apply_reason');
            $table->string('apply_contact');
            $table->string('apply_time');
            $table->string('return_time');
            $table->string('accept_opinion')->nullable()->default('审核中');
            $table->string('accept_time')->nullable();
            $table->string('accept_note')->nullable();
            $table->string('status')->default(1);
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
        Schema::dropIfExists('apply_item');
    }
}
