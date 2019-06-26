<?php

use App\Models\Exchange;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Первичный ключ');

            $table->unsignedInteger('bill_id')
                ->comment('Счёт оплаты');

            $table->unsignedInteger('user_id')
                ->nullable()
                ->comment('Ссылка на пользователя, совершающего обмен');

            $table->unsignedInteger('referrer_id')
                ->nullable()
                ->comment('Ссылка на пользователя, которому будет начислено реферальное вознаграждение');

            $table->unsignedInteger('route_id')
                ->comment('Направление обмена');

            $table->string('from_amount')
                ->comment('Сумма, которую отдает пользователь, включая комисиию платежной системы');

            $table->string('from_commission')
                ->comment('Комиссия платежной системы, с которой совершается обмен');

            $table->string('to_commission')
                ->comment('Комиссия плтежной системы, на которую идет обмен');

            $table->string('to_amount')
                ->comment('Сумма, которую получит пользователь на свой кошелёк');

            $table->string('referrer_reward')
                ->comment('Реферальное вознаграждение');

            $table->string('to_wallet')
                ->comment('Кошелек, на который нужно перевести средства');

            $table->string('transaction')
                ->nullable()
                ->comment('Транзакция выплаты');

            $table->enum('status', [
                Exchange::WAITING,
                Exchange::PAID,
                Exchange::CANCELED,
                Exchange::SUCCESS,
                Exchange::PENDING,
            ])
                ->default(Exchange::WAITING)
                ->comment('Статус заявки');

            $table->string('hash', 64)
                ->comment('Хеш заявки');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('referrer_id')->references('id')->on('users');
            $table->foreign('route_id')->references('id')->on('routes');
            $table->foreign('bill_id')->references('id')->on('bills');
        });

        DB::connection()
            ->getPdo()
            ->exec('ALTER TABLE `exchanges` auto_increment = ' . random_int(100000, 1000000));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchanges');
    }
}
