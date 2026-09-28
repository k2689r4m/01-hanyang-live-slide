<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodListInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_list_infos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('flag_num');
            $table->unsignedBigInteger('slide_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('slide_id')
                ->references('id')
                ->on('slides')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('good_list_infos');
    }
}
