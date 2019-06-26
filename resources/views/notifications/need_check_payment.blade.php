{{ request()->server('HTTP_HOST') }}
Проверить оплату {{ $notifiable->from_amount }} {{ $notifiable->route->reserve_from->currency }} на платежную систему {{ $notifiable->route->reserve_from->system }}, счёт № {{ $notifiable->bill_id }}
Заявка № {{ $notifiable->id }}