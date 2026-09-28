<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->string('answer_data');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lecture_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('slide_id');

            $table->boolean('result');
            $table->integer('score')->nullable();

            $table->foreign('lecture_id')
                ->references('id')
                ->on('lectures')
                ->onDelete('cascade');

            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('cascade');

            $table->foreign('slide_id')
                ->references('id')
                ->on('slides')
                ->onDelete('cascade');

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
        Schema::dropIfExists('answers');
    }
}
