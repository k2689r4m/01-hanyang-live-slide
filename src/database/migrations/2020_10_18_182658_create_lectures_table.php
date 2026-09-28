<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('lecture_goal_desc');
            $table->date('lecture_start_date');
            $table->date('lecture_end_date');
            $table->string('lecture_code')->unique();
            $table->boolean('use_nickname');
            $table->boolean('use_classes');
            $table->boolean('use_evaluation');
            $table->json('classes');
            $table->json('evaluation');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
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
        Schema::dropIfExists('lectures');
    }
}
