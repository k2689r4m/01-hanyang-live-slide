<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('user_url')->unique();
            $table->integer('active_always');
            $table->integer('record_always');
            $table->datetime('active_start_date');
            $table->datetime('active_end_date');
            $table->datetime('record_start_date');
            $table->datetime('record_end_date');
            $table->unsignedBigInteger('lecture_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('active')->default(false);
            $table->integer('active_member_count')->nullable();
            $table->json('slides_num')->nullable();

            $table->foreign('lecture_id')
            ->references('id')
            ->on('lectures')
            ->onDelete('cascade');
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->dateTime('date')->nullable();
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
        Schema::dropIfExists('classes');
    }
}
