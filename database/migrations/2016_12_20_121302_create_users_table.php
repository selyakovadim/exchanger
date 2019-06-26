<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Первичный ключ');

            $table->string('email')
                ->unique()
                ->comment('Email/Логин');

            $table->string('password', 60)
                ->comment('Пароль');

            $table->rememberToken();

            $table->unsignedInteger('referrer_id')
                ->nullable()
                ->comment('Реферовод');

            $table->timestamps();

            $table->foreign('referrer_id')
                ->references('id')
                ->on('users');
        });

        DB::connection()
            ->getPdo()
            ->exec('ALTER TABLE `users` auto_increment = ' . random_int(100000, 1000000));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
