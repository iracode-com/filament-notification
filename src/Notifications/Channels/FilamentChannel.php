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
                            ->icon( $message->get( 'icon', 'heroicon-o-check-circle' ) )
                            ->status( $message->get( 'status', 'success' ) )
                            ->color( $message->get( 'color', 'success' ) )
                            ->iconColor( $message->get( 'iconColor', 'success' ) )
                            ->send()
                            ->when(
                                $message->get( 'toDatabase', false ),
                                fn( NotificationFilament $filament ) => $filament->sendToDatabase( $notifiable )
                            )
        ;

    }

}
