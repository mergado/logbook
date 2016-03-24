<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('logs', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->text('body');
            $table->integer('eshop_id');
            $table->integer('project_id');
            $table->dateTime('date');
            $table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::table('log', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });
        Schema::drop('notes');
    }
}
