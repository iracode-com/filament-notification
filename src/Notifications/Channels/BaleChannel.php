<?php

namespace IracodeCom\FilamentNotification\Notifications\Channels;

use App\Models\User;
use Illuminate\Notifications\Notification;
use GuzzleHttp\Client;

class BaleChannel
{

    /** @var Client */
    protected Client $client;

    /** @var string|mixed|null */
    protected string | null $baleBotToken;

    public function __construct()
    {
        $this->client       = new Client();
        $this->baleBotToken = env( 'BALE_BOT_TOKEN' );
    }

    /**
     * @param $notifiable
     * @param Notification $notification
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send( $notifiable, Notification $notification ) : void
    {
        if ( ! $notifiable->routeNotificationFor( 'bale' ) )
        {
            return;
        }

        $message = $notification->toBale( $notifiable );

        $this->client->post( "https://tapi.bale.ai/bot{$this->baleBotToken}/sendMessage", [
            'json' => [
                'chat_id' => $notifiable->routeNotificationFor( 'bale' ),
                'text'    => $message[ 'text' ]
            ]
        ] );
    }
}
