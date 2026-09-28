<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('depth');
            $table->unsignedBigInteger('qna_id');
            $table->foreign('qna_id')
                ->references('id')
                ->on('qnas')
                ->onDelete('cascade');
            $table->integer('bundle_id'); // 상위 댓글 아이디 (상위 댓글은 자신의 아이디)
            $table->longText('content');
            $table->boolean('lock');
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
        Schema::dropIfExists('comments');
    }
}
