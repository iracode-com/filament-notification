# Installing

First Install Package
```bash
$ composer require iracode-com/filament-notification
```

Publish The Provider Files To Project
```bash
php artisan vendor:publish --provider=IracodeCom\FilamentNotification\FilamentNotificationServiceProvider
```

Run Artisan Migrate For Add Columns To Table `Users`
```bash
php artisan migrate
```

Update Fillable To Model `app/Models/User.php`
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable; // <-- Notifiable is important

    protected $fillable = [
    
        // ...
        'prefers_bale',
        'prefers_telegram',
        'prefers_sms',
        'telegram_chat_id',
        'bale_chat_id',
        'phone'
        // ...
        
    ];
    
    public function routeNotificationForSms()
    {
        return $this->phone;
    }

    public function routeNotificationForBale()
    {
        return $this->bale_chat_id;
    }
    
    public function routeNotificationForTelegram()
    {
        return $this->telegram_chat_id;
    }
    
}
```

Add Plugin Filament To List `app/Providers/Filament/AdminPanelProvider.php`
```php
<?php

namespace App\Providers\Filament;

use IracodeCom\FilamentNotification\FilamentNotificationPlugin;
use Filament\PanelProvider;
use Filament\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel( Panel $panel ) : Panel
    {
        return $panel
            ->plugins( [

                FilamentNotificationPlugin::make(), // <---
                
                FilamentNotificationPlugin::make()
                                            ->setGridColumnConfig() // optional
                                            ->setGridColumnNotify() // optional
                                            ->setSectionColumnSpan() // optional
                                            ->usingPage() // optional

            ] )
        ;
    }
}
```

Config `.env` File
```dotenv
SMS_DRIVER=log
SMS_USERNAME=
SMS_PASSWORD=
SMS_NUMBER=

TELEGRAM_BOT_TOKEN=
BALE_BOT_TOKEN=
```
