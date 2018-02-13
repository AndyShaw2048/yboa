<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('before');
            $table->integer('changed');
            $table->unsignedInteger('after');
            $table->unsignedInteger('operate_id');
            $table->string('operate_reason')->nullable();
            $table->string('operate_time');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE item_details AUTO_INCREMENT = 10000;");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_details');
    }
}
