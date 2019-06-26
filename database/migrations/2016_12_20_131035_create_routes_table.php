<?php

use App\Models\Route;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {

            $table->increments('id')
                ->comment('Первичный ключ');

            $table->unsignedInteger('reserve_from_id')
                ->comment('Резерв, с которого меняют');

            $table->unsignedInteger('reserve_to_id')
                ->comment('Резерв, на который меняют');

            $table->string('rate')
                ->comment('Курс обмена');

            $table->enum('type', [
                Route::MANUAL,
                Route::SEMIAUTO,
                Route::AUTO,
            ])
                ->default(Route::MANUAL)
                ->comment('Тип направления');

            $table->foreign('reserve_from_id')
                ->references('id')
                ->on('reserves');

            $table->foreign('reserve_to_id')
                ->references('id')
                ->on('reserves');

            $table->unique(['reserve_from_id', 'reserve_to_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routes');
    }
}
