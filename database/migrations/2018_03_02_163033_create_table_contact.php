<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->string('college')->nullable();
            $table->string('grade')->nullable();
            $table->string('tel');
            $table->string('qq')->nullable();
            $table->string('category'); // 1：组织负责人 2：办公室 3：技术部 4：宣传部 5：新闻部
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact');
    }
}
