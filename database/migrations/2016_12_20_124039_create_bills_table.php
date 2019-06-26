<?php

use App\Models\Bill;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Уникальный ключ');

            $table->unsignedInteger('user_id')
                ->nullable()
                ->comment('Пользователь, на которого выставлен счёт');

            $table->string('amount')
                ->comment('Сумма для оплаты');

            $table->string('currency', 3)
                ->comment('Валюта счёта');

            $table->string('transaction')
                ->unique()
                ->nullable()
                ->comment('Транзакция оплаты');

            $table->enum('status', [
                Bill::SUCCESS,
                Bill::CANCELED,
                Bill::WAITING]
            )
                ->default(Bill::WAITING)
                ->comment('Статус счёта');

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });

        DB::connection()
            ->getPdo()
            ->exec('ALTER TABLE `bills` auto_increment = ' . random_int(100000, 1000000));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
