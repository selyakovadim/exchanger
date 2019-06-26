<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AlertsSeeder::class);
        $this->call(ContactsSeeder::class);
        $this->call(PartnersSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(UsersSeeder::class);

        $this->call(ReservesSeeder::class);
        $this->call(RoutesSeeder::class);
    }
}
