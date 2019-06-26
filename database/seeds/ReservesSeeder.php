<?php

use App\Models\Reserve;
use Illuminate\Database\Seeder;

class ReservesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Payeer USD
         */
        Reserve::create([
            'system' => 'Payeer',
            'currency' => 'USD',
            'balance' => mt_rand(1, 1000),
            'min' => 0.99,
            'commission' => 0.95,
            'label' => 'PRUSD',
            'regex' => '/^P[0-9]+$/',
            'placeholder' => 'P1234567',
        ]);

        /**
         * Payeer RUB
         */
        Reserve::create([
            'system' => 'Payeer',
            'currency' => 'RUB',
            'balance' => mt_rand(1, 1000),
            'min' => 99,
            'commission' => 0.95,
            'label' => 'PRRUB',
            'regex' => '/^P[0-9]+$/',
            'placeholder' => 'P1234567',
        ]);

        /**
         * PerfectMoney USD
         */
        Reserve::create([
            'system' => 'PerfectMoney',
            'currency' => 'USD',
            'balance' => mt_rand(1, 1000),
            'min' => 0.99,
            'commission' => 0.50,
            'label' => 'PMUSD',
            'regex' => '/U[0-9]{5,9}/',
            'placeholder' => 'U12345678',
        ]);

        /**
         * Яндекс.Деньги RUB
         */
        Reserve::create([
            'system' => 'YandexMoney',
            'currency' => 'RUB',
            'balance' => mt_rand(1, 1000),
            'min' => 99,
            'commission' => 0.00,
            'label' => 'YAMRUB',
            'regex' => '/^41001[0-9]{7,10}$/',
            'placeholder' => '41001234567890',
        ]);

        /**
         * Qiwi RUB
         */
        Reserve::create([
            'system' => 'Qiwi',
            'currency' => 'RUB',
            'balance' => mt_rand(1, 1000),
            'min' => 99,
            'commission' => 0.00,
            'label' => 'QWRUB',
            'regex' => '/^\+7[0-9]{6,14}$/',
            'placeholder' => '+79115223344',
        ]);

        /**
         * AdvCash USD
         */
        Reserve::create([
            'system' => 'AdvCash',
            'currency' => 'USD',
            'balance' => mt_rand(1, 1000),
            'min' => 0.99,
            'commission' => 0.00,
            'label' => 'ADVCUSD',
            'regex' => '/^(.*@.*)$/',
            'placeholder' => 'example@mail.ru',
        ]);

        /**
         * AdvCash RUB
         */
        Reserve::create([
            'system' => 'AdvCash',
            'currency' => 'RUB',
            'balance' => mt_rand(1, 1000),
            'min' => 99,
            'commission' => 0.00,
            'label' => 'ADVCRUB',
            'regex' => '/^(.*@.*)$/',
            'placeholder' => 'example@mail.ru',
        ]);

        /**
         * OkPay USD
         */
        Reserve::create([
            'system' => 'OkPay',
            'currency' => 'USD',
            'balance' => mt_rand(1, 1000),
            'min' => 0.99,
            'commission' => 0.50,
            'label' => 'OKUSD',
            'regex' => '/OK[0-9]{9}/',
            'placeholder' => 'OK123456789',
        ]);

        /**
         * BitCoin BTC
         */
        Reserve::create([
            'system' => 'Bitcoin',
            'currency' => 'BTC',
            'balance' => mt_rand(1, 1000),
            'min' => 0.001,
            'commission' => 0.00,
            'label' => 'BTC',
            'regex' => '/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/',
            'placeholder' => 'Биткоин-адрес',
        ]);


        /**
         * Tinkoff RUB
         */
        Reserve::create([
            'system' => 'Tinkoff',
            'currency' => 'RUB',
            'balance' => mt_rand(1, 1000),
            'min' => 99,
            'commission' => 0.00,
            'label' => 'TCSBRUB',
            'regex' => '/^5[1-5][0-9]{14}$/',
            'placeholder' => '5377730000000123',
        ]);

        /**
         * Sberbank RUB
         */
        Reserve::create([
            'system' => 'Sberbank',
            'currency' => 'RUB',
            'balance' => mt_rand(1, 1000),
            'min' => 99,
            'commission' => 0.00,
            'label' => 'SBERRUB',
            'regex' => '/^5[1-5][0-9]{14}$/',
            'placeholder' => '5377730000000123',
        ]);
    }
}