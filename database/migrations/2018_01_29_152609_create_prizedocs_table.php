<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrizedocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prizedocs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('apply_id');
            $table->string('apply_contact');
            $table->string('activity_name');
            $table->string('doc_activity');
            $table->string('doc_prize');
            $table->string('doc_summary')->nullable();
            $table->string('apply_time');
            $table->string('apply_note')->nullable();
            $table->string('accept_id')->nullable();
            $table->string('accept_opinion')->nullable();
            $table->string('accept_time')->nullable();
            $table->string('accept_note')->nullable();
            $table->string('accept_sum_id')->nullable();
            $table->string('accept_sum_opinion')->nullable();
            $table->string('accept_sum_time')->nullable();
            $table->string('accept_sum_note')->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE prizedocs AUTO_INCREMENT = 10000;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prizedocs');
    }
}
