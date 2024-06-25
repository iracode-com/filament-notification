<?php

namespace IracodeCom\FilamentNotification\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use IracodeCom\FilamentNotification\Notifications\Channels\BaleChannel;
use IracodeCom\FilamentNotification\Notifications\Channels\FilamentChannel;
use IracodeCom\FilamentNotification\Notifications\Channels\TelegramChannel;
use IracodeCom\FilamentNotification\Notifications\Channels\SmsChannel;

class UserNotification extends Notification
{
    use Queueable;

    protected $message;

    public function __construct( $message )
    {
        $this->message = $message;
    }

    public function via( User $notifiable )
    {
        $channels = [ FilamentChannel::class ];

        if ( $notifiable->prefers_telegram )
        {
            $channels[] = TelegramChannel::class;
        }

        if ( $notifiable->prefers_sms )
        {
            $channels[] = SmsChannel::class;
        }

        if ( $notifiable->prefers_bale )
        {
            $channels[] = BaleChannel::class;
        }

        return $channels;
    }

    public function toMail( $notifiable )
    {
        return ( new MailMessage )
            ->line( $this->message )
        ;
    }

    public function toTelegram( $notifiable )
    {
        return [
            'text' => $this->message,
        ];
    }

    public function toSms( $notifiable )
    {
        return [
            'body' => $this->message,
        ];
    }

    public function toBale( $notifiable )
    {
        return [
            'text' => $this->message,
        ];
    }

    public function toFilament( $notifiable )
    {
        return [
            'body' => $this->message,
        ];
    }
}
