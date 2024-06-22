<?php

namespace IracodeCom\FilamentNotification;

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
        ;
    }

    public function boot()
    {


    }

}
