<?php

use App\Models\Payout;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Первичный ключ');

            $table->unsignedInteger('user_id')
                ->nullable()
                ->comment('Пользователь, которому осуществляется выплата');

            $table->string('system')
                ->comment('Система для выплаты');

            $table->string('amount')
                ->comment('Сумма выплаты');

            $table->string('currency', 3)
                ->comment('Валюта выплаты');

            $table->string('wallet')
                ->comment('Номер кошелька, на который осуществляется выплата');

            $table->string('transaction')
                ->nullable()
                ->comment('Номер транзакции выплаты');

            $table->enum('status', [
                Payout::PENDING,
                Payout::CANCELED,
                Payout::SUCCESS
            ])
                ->default(Payout::PENDING)
                ->comment('Статус выплаты');

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });

        DB::connection()
            ->getPdo()
            ->exec('ALTER TABLE `payouts` auto_increment = ' . random_int(100000, 1000000));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payouts');
    }
}
