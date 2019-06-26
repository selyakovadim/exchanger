<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Первичный ключ');

            $table->string('name')
                ->unique()
                ->comment('Наименования партнера');

            $table->boolean('index')
                ->default(1)
                ->comment('Отображать на главной');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partners');
    }
}
