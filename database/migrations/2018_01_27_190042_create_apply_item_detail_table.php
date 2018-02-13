<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplyItemDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_item_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('apply_item_id');
            $table->unsignedInteger('accept_1_id')->nullable();
            $table->string('accept_1_opn')->nullable();
            $table->string('accept_1_note')->nullable();
            $table->string('accept_1_time')->nullable();
            $table->unsignedInteger('accept_2_id')->nullable();
            $table->string('accept_2_opn')->nullable();
            $table->string('accept_2_note')->nullable();
            $table->string('accept_2_time')->nullable();
            $table->unsignedInteger('accept_3_id')->nullable();
            $table->string('accept_3_opn')->nullable();
            $table->string('accept_3_note')->nullable();
            $table->string('accept_3_time')->nullable();
            $table->unsignedInteger('accept_4_id')->nullable();
            $table->string('accept_4_opn')->nullable();
            $table->string('accept_4_note')->nullable();
            $table->string('accept_4_time')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE apply_item_detail AUTO_INCREMENT = 10000;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apply_item_detail');
    }
}
