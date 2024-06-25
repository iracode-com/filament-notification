<?php

namespace IracodeCom\FilamentNotification;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentNotificationServiceProvider extends ServiceProvider
{

    /**
     * @param Package $package
     * @return void
     */
    public function configurePackage( Package $package ) : void
    {
        $package->name( 'filament-notification' )
                ->hasMigrations()
                ->hasConfigFile()
                ->hasViews()
                ->hasRoute('web')
        ;
    }

    /**
     * @return void
     */
    public static function InstallPackage()
    {

        if ( ! File::exists( app_path( 'Providers/Filament/' ) ) )
            Artisan::call( 'filament:install --panels' );

    }

}
