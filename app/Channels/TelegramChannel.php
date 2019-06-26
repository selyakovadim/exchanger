<?php

namespace App\Channels;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

class TelegramChannel
{
    const URL = 'https://alarmerbot.ru/';

    public function send($notifiable, Notification $notification)
    {
        $client = new Client();

        foreach ($this->recipients() as $key) {
            $client->get(self::URL, [
                'query' => [
                    'key' => $key,
                    'message' => $notification->toMessage($notifiable)->render(),
                ]
            ]);
        }
    }

    private function recipients()
    {
        return [];
    }
}