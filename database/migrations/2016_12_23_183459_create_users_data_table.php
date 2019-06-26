<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_data', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Первичный ключ');

            $table->unsignedInteger('user_id')
                ->comment('Пользователь');

            $table->string('key')
                ->comment('Ключ данных');

            $table->string('value')
                ->comment('Значение данных');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->unique(['user_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_data');
    }
}
