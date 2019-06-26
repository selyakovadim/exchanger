<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserves', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Первичный ключ');

            $table->string('system')
                ->comment('Платежная система');

            $table->string('currency', 3)
                ->comment('Валюта резерва');

            $table->string('balance')
                ->comment('Остаток на резерве');

            $table->string('min')
                ->comment('Минимальная сумма перевода');

            $table->decimal('commission', 4, 2)
                ->comment('Комиссия в %');

            $table->string('min_commission')
                ->default('0.00')
                ->comment('Минимальная комиссия');

            $table->string('label')
                ->unique()
                ->comment('Идентификатор резерва');

            $table->string('regex')
                ->nullable()
                ->comment('Регулярное выражения для валидации');

            $table->string('placeholder')
                ->nullable()
                ->comment('Подсказка, использующаяся в формах');

            $table->unique(['system', 'currency']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserves');
    }
}
