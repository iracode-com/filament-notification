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
        $package->name( 'iracode-filament-notification' )
                ->hasMigration( '2024_06_22_133203_add_notification_preferences_to_users_table' )
                ->hasConfigFile( 'sms' )
                ->hasViews()
                ->hasTranslations()
                ->hasRoute( 'web' )
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
