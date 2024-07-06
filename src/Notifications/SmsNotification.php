<?php

namespace IracodeCom\FilamentNotification\Notifications;

use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use IracodeCom\FilamentNotification\Notifications\Channels\BaleChannel;
use IracodeCom\FilamentNotification\Notifications\Channels\FarazSmsPatternChannel;
use IracodeCom\FilamentNotification\Notifications\Channels\TelegramChannel;

class SmsNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct( protected string $patternCode, protected array $data = [] )
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via( $notifiable ) : array
    {
        return [ FarazSmsPatternChannel::class ];
    }

    public function toSms( $notifiable ) : array
    {
        return array_merge( [ 'patterncode' => $this->patternCode, ], $this->data );
    }

}
