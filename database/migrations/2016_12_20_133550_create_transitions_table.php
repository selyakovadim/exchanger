<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transitions', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Первичный ключ');

            $table->text('site')
                ->comment('Сайт, с которого перешёл пользователь');

            $table->unsignedInteger('referrer_id')
                ->nullable()
                ->comment('Реферовод');

            $table->timestamps();

            $table->foreign('referrer_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transitions');
    }
}
