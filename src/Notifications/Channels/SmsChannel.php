<?php

namespace Iracode\FilamentNotification\Notifications\Channels;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Tzsk\Sms\Facades\Sms;

class SmsChannel
{

    /**
     * @param User $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send( User $notifiable, Notification $notification ) : void
    {
        if ( ! $notifiable->routeNotificationFor( 'sms' ) )
        {
            return;
        }

        $message = $notification->toSms( $notifiable );

        Sms::send( $message[ 'body' ], function ( $sms ) use ( $notifiable ) {
            $sms->to( $notifiable->routeNotificationFor( 'sms' ) );
        } );
    }
}
