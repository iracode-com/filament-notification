<?php

namespace IracodeCom\FilamentNotification;

use Filament\Contracts\Plugin;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use IracodeCom\FilamentNotification\Concerns\CanCustomizeColumns;
use IracodeCom\FilamentNotification\Filament\Pages\NotificationSettingsPage;

class FilamentNotificationPlugin implements Plugin
{
    use CanCustomizeColumns;

    /**
     * @return string
     */
    public function getId() : string
    {
        return 'filament-notification';
    }

    /**
     * @param Panel $panel
     * @return void
     */
    public function register( Panel $panel ) : void
    {
        $panel->pages( [
            NotificationSettingsPage::class
        ] );
    }

    /**
     * @param Panel $panel
     * @return void
     */
    public function boot( Panel $panel ) : void
    {
        $panel->userMenuItems( [

            MenuItem::make()
                    ->label( 'Notifications' )
                    ->url( NotificationSettingsPage::getUrl() )
                    ->icon( 'heroicon-s-bell-alert' ),

        ] );
    }

    /**
     * @return static
     */
    public static function make() : static
    {
        return app( static::class );
    }

    /**
     * @return static
     */
    public static function get() : static
    {
        return filament( app( static::class )->getId() );
    }

}
