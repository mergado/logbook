<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProjectTable extends Migration
{
    public function up()
    {
//        Schema::create('projects', function(Blueprint $table){
//            $table->increments('id');
//            $table->integer('eshop_id')->unsigned();
//            $table->string('name');
//
//            $table->index('eshop_id');
//            $table->foreign('eshop_id')
//                ->references('id')->on('eshops')
//                ->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

//        Schema::drop('projects');

    }
}
