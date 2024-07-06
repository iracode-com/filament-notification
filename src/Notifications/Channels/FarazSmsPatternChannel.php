<?php

namespace IracodeCom\FilamentNotification\Notifications\Channels;

use Illuminate\Notifications\Notification;

class FarazSmsPatternChannel
{

    /**
     * @param $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send( $notifiable, Notification $notification ) : void
    {
        if ( ! $notifiable->routeNotificationFor( 'sms' ) )
        {
            return;
        }

        $message = $notification->toSms( $notifiable );

        $formattedArray = [];
        foreach ( $message as $key => $value )
        {
            $formattedArray[] = "{$key}={$value}";
        }
        $string = implode( " \n ", $formattedArray );

        sms()->send( $string )
             ->to( $notifiable->routeNotificationFor( 'sms' ) )
             ->dispatch()
        ;
    }

}
