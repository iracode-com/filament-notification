<?php

namespace IracodeCom\FilamentNotification\Notifications\Channels;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramChannel
{
    protected Api $telegram;

    /**
     * @throws TelegramSDKException
     */
    public function __construct()
    {
        $this->telegram = new Api( env( 'TELEGRAM_BOT_TOKEN' ) );
    }

    /**
     * @param $notifiable
     * @param Notification $notification
     * @return void
     * @throws TelegramSDKException
     */
    public function send( $notifiable, Notification $notification ) : void
    {
        if ( ! $notifiable->routeNotificationFor( 'telegram' ) )
        {
            return;
        }

        $message = $notification->toTelegram( $notifiable );

        $this->telegram->sendMessage( [
            'chat_id' => $notifiable->routeNotificationFor( 'telegram' ),
            'text'    => $message[ 'text' ]
        ] );
    }

}
