<?php

use App\Models\Reserve;
use App\Models\Route;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoutesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reserves = Reserve::all();

        foreach ($reserves as $from) {
            foreach ($reserves as $to) {

                if ($from->id !== $to->id) {
                    Route::create([
                        'reserve_from_id' => $from->id,
                        'reserve_to_id' => $to->id,
                        'rate' => '1.00',
                        'type' => Route::MANUAL
                    ]);
                }
            }
        }
    }
}
