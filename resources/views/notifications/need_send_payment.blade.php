{{ request()->server('HTTP_HOST') }}
Выплатить {{ $notifiable->to_amount }} {{ $notifiable->route->reserve_to }} на номер {{ $notifiable->to_wallet}}
Заявка № {{ $notifiable->id }}