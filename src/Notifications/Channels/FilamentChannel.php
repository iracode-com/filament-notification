<?php

namespace IracodeCom\FilamentNotification\Notifications\Channels;

use App\Models\User;
use Filament\Notifications\Notification as NotificationFilament;
use Illuminate\Notifications\Notification;

class FilamentChannel
{

    /**
     * @param $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send( $notifiable, Notification $notification ) : void
    {
        if ( ! class_exists( 'Filament\Notifications\Notification' ) )
        {
            return;
        }

        $message = collect( $notification->toFilament( $notifiable ) );

        NotificationFilament::make()
                            ->body( $message->get( 'body' ) )
                            ->icon( $message->get( 'icon' ) )
                            ->status( $message->get( 'status' ) )
                            ->color( $message->get( 'color' ) )
                            ->iconColor( $message->get( 'iconColor' ) )
                            ->send()
                            ->when(
                                $message->get( 'toDatabase', false ),
                                fn( NotificationFilament $filament ) => $filament->toDatabase()
                            )
        ;

    }

}
