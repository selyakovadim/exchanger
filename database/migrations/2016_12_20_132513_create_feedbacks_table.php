<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Первичный ключ');

            $table->string('username')
                ->comment('Имя пользователя');

            $table->string('email')
                ->comment('Электронная почта пользователя');

            $table->unsignedInteger('exchange_id')
                ->nullable()
                ->comment('Заявка на обмен');

            $table->text('message')
                ->comment('Сообщение');

            $table->timestamps();

            $table->foreign('exchange_id')
                ->references('id')
                ->on('exchanges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
}
