<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_balances', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Первичный ключ');

            $table->unsignedInteger('user_id')
                ->comment('Пользователь');

            $table->string('currency', 3)
                ->comment('Валюта баланса');

            $table->string('amount')
                ->comment('Сумма баланса');

            $table->unique(['user_id', 'currency']);

            $table->foreign('user_id')
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
        Schema::dropIfExists('users_balances');
    }
}
