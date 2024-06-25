<?php

namespace IracodeCom\FilamentNotification;

use Filament\Contracts\Plugin;
use Filament\FilamentManager;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use IracodeCom\FilamentNotification\Concerns\CanCustomizeColumns;
use IracodeCom\FilamentNotification\Concerns\CanCustomizePage;

class FilamentNotificationPlugin implements Plugin
{
    use CanCustomizeColumns, CanCustomizePage;

    /**
     * @return string
     */
    public function getId() : string
    {
        return 'iracode-filament-notification';
    }

    /**
     * @param Panel $panel
     * @return void
     */
    public function register( Panel $panel ) : void
    {
        $panel->pages( [ $this->getPage() ] );
    }

    /**
     * @param Panel $panel
     * @return void
     */
    public function boot( Panel $panel ) : void
    {
        $panel->userMenuItems( [

            MenuItem::make()
                    ->label( __( 'iracode-filament-notification::label.Notifications' ) )
                    ->url( $this->page::getUrl() )
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
     * @return Plugin|FilamentManager
     */
    public static function get() : FilamentManager | Plugin
    {
        return filament( app( static::class )->getId() );
    }

}
