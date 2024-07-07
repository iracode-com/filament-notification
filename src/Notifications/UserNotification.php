<?php

namespace IracodeCom\FilamentNotification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use IracodeCom\FilamentNotification\Notifications\Channels\AvanakSmsChannel;
use IracodeCom\FilamentNotification\Notifications\Channels\BaleChannel;
use IracodeCom\FilamentNotification\Notifications\Channels\FilamentChannel;
use IracodeCom\FilamentNotification\Notifications\Channels\SmsChannel;
use IracodeCom\FilamentNotification\Notifications\Channels\TelegramChannel;

class UserNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected string $message,
        protected bool   $bale = true,
        protected bool   $telegram = true,
        protected bool   $sms = true,
        protected bool   $filament = true,
        protected bool   $avanak = true
    )
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via( $notifiable )
    {
        $channels = [];

        if ( $notifiable->prefers_telegram && $this->telegram )
        {
            $channels[] = TelegramChannel::class;
        }

        if ( $notifiable->prefers_sms && $this->sms )
        {
            $channels[] = SmsChannel::class;
        }

        if ( $notifiable->prefers_sms && $this->avanak )
        {
            $channels[] = AvanakSmsChannel::class;
        }

        if ( $this->filament )
        {
            $channels[] = FilamentChannel::class;
        }

        if ( $notifiable->prefers_bale && $this->bale )
        {
            $channels[] = BaleChannel::class;
        }

        return $channels;
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
