<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Первичный ключ');

            $table->string('number', 64)
                ->unique()
                ->comment('Индентификатор адреса');

            $table->unsignedInteger('bill_id')
                ->nullable()
                ->comment('Текущий номер заказа');

            $table->foreign('bill_id')
                ->references('id')
                ->on('bills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
