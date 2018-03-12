<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplyRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_role', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('apply_id');
            $table->unsignedInteger('apply_role');
            $table->string('apply_reason');
            $table->string('accept_id')->nullable();
            $table->string('accept_opinion')->nullable();
            $table->string('accept_note')->nullable();
            $table->string('accept_time')->nullable();
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
        Schema::dropIfExists('apply_role');
    }
}
