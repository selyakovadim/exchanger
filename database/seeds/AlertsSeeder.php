<?php

use App\Models\Alert;
use Illuminate\Database\Seeder;

class AlertsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Alert::create([
            'text' => 'Вы можете сохранить Ваши кошельки в личном кабинете для более быстрого обмена'
        ]);
    }
}
