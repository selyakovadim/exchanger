<?php

use App\Models\User;
use App\Models\UserData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {

            $user = User::create([
                'email' => 'selyakovadim@gmail.com',
                'password' => bcrypt('123123'),
            ]);

            UserData::create([
                'user_id' => $user->id,
                'key' => UserData::NAME,
                'value' => 'Вадим',
            ]);

        });
    }
}
