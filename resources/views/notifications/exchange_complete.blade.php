{{ request()->server('HTTP_HOST') }}
Совершён обмен {{ $notifiable->from_amount }} {{ $notifiable->route->reserve_from }} на {{ $notifiable->to_amount }} {{ $notifiable->route->reserve_to }}
Заявка №{{ $notifiable->id }}