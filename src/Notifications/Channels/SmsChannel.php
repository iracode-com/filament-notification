<?php

namespace IracodeCom\FilamentNotification\Notifications\Channels;


use Illuminate\Notifications\Notification;
use Tzsk\Sms\Facades\Sms;

class SmsChannel
{

    public function send( $notifiable, Notification $notification ) : void
    {
        if ( ! $notifiable->routeNotificationFor( 'sms' ) )
        {
            return;
        }

        $message = $notification->toSms( $notifiable );

        sms()->via( $message[ 'via' ] ?? config( 'sms.default' ) )
             ->send( $message[ 'body' ] )
             ->to( $notifiable->routeNotificationFor( 'sms' ) )
             ->dispatch()
        ;
    }

}
