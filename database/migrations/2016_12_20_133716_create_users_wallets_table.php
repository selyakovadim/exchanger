<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_wallets', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Первичный ключ');

            $table->unsignedInteger('user_id')
                ->comment('Пользователь');

            $table->unsignedInteger('reserve_id')
                ->comment('Для какого резерва кошелёк');

            $table->string('number')
                ->comment('Номер кошелька');

            $table->unique(['user_id', 'reserve_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('reserve_id')
                ->references('id')
                ->on('reserves');
        });

        DB::connection()
            ->getPdo()
            ->exec('ALTER TABLE `users_wallets` auto_increment = ' . random_int(100000, 1000000));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_wallets');
    }
}
