<?php

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::create([
            'key' => 'project',
            'value' => 'Exchanger',
        ]);

        Contact::create([
            'key' => 'telegram',
            'value' => '@exchanger',
        ]);

        Contact::create([
            'key' => 'vk',
            'value' => 'exchanger',
        ]);

        Contact::create([
            'key' => 'skype',
            'value' => 'exchanger',
        ]);

        Contact::create([
            'key' => 'email',
            'value' => 'help@exchanger.site',
        ]);

        Contact::create([
            'key' => 'phone',
            'value' => '8 800 123 45 67',
        ]);
    }
}
