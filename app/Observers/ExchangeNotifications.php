<?php

namespace App\Observers;

use App\Models\Exchange;
use App\Notifications\ExchangeComplete;
use App\Notifications\NeedCheckPayment;
use App\Notifications\NeedSendPayment;
use Illuminate\Support\Facades\Notification;

class ExchangeNotifications
{
    public function updated(Exchange $exchange)
    {
        if ($exchange->status === Exchange::SUCCESS) {
            Notification::send($exchange, new ExchangeComplete());
        }

        if ($exchange->status === Exchange::PAID) {
            Notification::send($exchange, new NeedSendPayment());
        }

        if ($exchange->status === Exchange::PENDING) {
            Notification::send($exchange, new NeedCheckPayment());
        }
    }
}