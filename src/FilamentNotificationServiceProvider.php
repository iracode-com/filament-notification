<?php

namespace IracodeCom\FilamentNotification;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentNotificationServiceProvider extends PackageServiceProvider
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
