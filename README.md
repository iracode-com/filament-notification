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

# how to use

For Example Create One `Notification` Form Laravel:
> You Can Create Your Custom Notification Also
```php
<?php

namespace IracodeCom\FilamentNotification\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use IracodeCom\FilamentNotification\Notifications\Channels\BaleChannel;
use IracodeCom\FilamentNotification\Notifications\Channels\FilamentChannel;
use IracodeCom\FilamentNotification\Notifications\Channels\TelegramChannel;
use IracodeCom\FilamentNotification\Notifications\Channels\SmsChannel;

class UserNotification extends Notification
{
    use Queueable;

    protected $message;

    public function __construct( $message )
    {
        $this->message = $message;
    }

    public function via( User $notifiable )
    {
        $channels = [ FilamentChannel::class ];

        if ( $notifiable->prefers_telegram )
        {
            $channels[] = TelegramChannel::class;
        }

        if ( $notifiable->prefers_sms )
        {
            $channels[] = SmsChannel::class;
        }

        if ( $notifiable->prefers_bale )
        {
            $channels[] = BaleChannel::class;
        }

        return $channels;
    }

    public function toMail( $notifiable )
    {
        return ( new MailMessage )
            ->line( $this->message )
        ;
    }

    public function toTelegram( $notifiable )
    {
        return [
            'text' => $this->message,
        ];
    }

    public function toSms( $notifiable )
    {
        return [
            'body' => $this->message,
        ];
    }

    public function toBale( $notifiable )
    {
        return [
            'text' => $this->message,
        ];
    }

    public function toFilament( $notifiable )
    {
        return [
            'body' => $this->message,
        ];
    }
}
```

Example Code Using:
```php
use IracodeCom\FilamentNotification\Notifications\UserNotification;

$user = \App\Models\User::find( 1 );
$user->notify(
    new UserNotification( 'Hello' )
);
```


```php
use IracodeCom\FilamentNotification\Notifications\UserNotification;
use \App\Models\User;

foreach ( User::all() as $user )
{

    $user->notify( new UserNotification( 'Welcome' ) );

}

// Or

User::get()->each->notify( new UserNotification( 'Welcome' ) );

```

If You Like Make New Notification, Can Use Thia Command

```bash
php artisan make:notification YOUR_NOTIFICATION_NAME
```

# Security

If you discover any security related issues, please email aliw1382@gmail.com instead of using the issue tracker.

# License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
