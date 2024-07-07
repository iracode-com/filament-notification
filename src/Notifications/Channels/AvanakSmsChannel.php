<?php

namespace IracodeCom\FilamentNotification\Notifications\Channels;

use Illuminate\Notifications\Notification;
use SoapClient;

class AvanakSmsChannel
{

    /**
     * @throws \SoapFault
     */
    public function send( $notifiable, Notification $notification ) : void
    {
        if ( ! $notifiable->routeNotificationFor( 'sms' ) )
        {
            return;
        }

        $message = $notification->toSms( $notifiable );

        ini_set( "soap.wsdl_cache_enabled", "0" );

        $service_client = new SoapClient( 'https://portal.avanak.ir/webservice3.asmx?wsdl', array( 'encoding' => 'UTF-8' ) );

        $parameters[ 'userName' ] = $message[ 'username' ] ?? config( 'sms.config.avanak.username', env( 'AVANAK_SMS_USERNAME' ) );
        $parameters[ 'password' ] = $message[ 'password' ] ?? config( 'sms.config.avanak.password', env( 'AVANAK_SMS_PASSWORD' ) );

        $parameters[ 'number' ]         = $notifiable->routeNotificationFor( 'sms' );
        $parameters[ 'vote' ]           = $message[ 'vote' ] ?? false;
        $parameters[ 'serverid' ]       = $message[ 'serverid' ] ?? 0;
        $parameters[ 'text' ]           = $message[ 'body' ];
        $parameters[ 'CallFromMobile' ] = $message[ 'CallFromMobile' ] ?? '';

        $service_client->QuickSendWithTTS( $parameters )->QuickSendWithTTSResult;

    }

}
