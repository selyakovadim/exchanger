<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Первичный ключ');

            $table->string('name')
                ->comment('Название баннера');

            $table->string('image')
                ->comment('Ссылка на изображение');

            $table->boolean('visible')
                ->default(1)
                ->comment('Видимость баннера');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
