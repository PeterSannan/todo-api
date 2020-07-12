<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->dateTime('datetime');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('status');
            $table->timestamps();

           $table->foreign('category_id')->references('id')->on('categories')->cascade('delete');
           $table->foreign('user_id')->references('id')->on('users')->cascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
