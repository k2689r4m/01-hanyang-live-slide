<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('type');

            $table->boolean('activation_answer')->nullable();        //정답 활성화
            $table->boolean('activation_time_limit')->nullable();     //제한시간 활성화
            $table->boolean('activation_score')->nullable();         //점수 활성화
            $table->boolean('activation_first_come')->nullable();     //선착순 점수 활성화
            $table->boolean('activation_layout')->nullable();        //리더보드 활성화

            $table->json('slide_content');
            $table->boolean('available');
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')
            ->references('id')
            ->on('classes')
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
        Schema::dropIfExists('slides');
    }
}
