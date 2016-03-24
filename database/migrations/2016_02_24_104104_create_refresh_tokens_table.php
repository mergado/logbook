<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateRefreshTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refresh_tokens', function(Blueprint $table){
            $table->string('id', 50);
            $table->integer('user_id')->unsigned();
            $table->integer('eshop_id');
            $table->integer('expire_time');

            $table->primary('id');
            $table->index('eshop_id', 'user_id');
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
        Schema::drop('refresh_tokens');
    }
}
