<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | This value determines which of the following gateway to use.
    | You can switch to a different driver at runtime.
    |
    */
    'default' => env( 'SMS_DRIVER', 'log' ),

    /*
    |--------------------------------------------------------------------------
    | List of Drivers
    |--------------------------------------------------------------------------
    |
    | These are the list of drivers to use for this package.
    | You can change the name. Then you'll have to change
    | it in the map array too.
    |
    */
    'drivers' => [

        'log'                => [
            'driver' => 'log',
        ],
        // Install: composer require aws/aws-sdk-php
        'sns'                => [
            'key'    => 'Your AWS SNS Access Key',
            'secret' => 'Your AWS SNS Secret Key',
            'region' => 'Your AWS SNS Region',
            'from'   => 'Your AWS SNS Sender ID', // sender
            'type'   => 'Transactional', // Or: 'Promotional'
        ],
        'textlocal'          => [
            'url'      => 'http://api.textlocal.in/send/', // Country Wise this may change.
            'username' => env( 'SMS_USERNAME' ),
            'hash'     => env( 'SMS_HASH_KEY' ),
            'from'     => 'Sender Name', // sender
        ],
        // Install: composer require twilio/sdk
        'twilio'             => [
            'sid'   => 'Your SID',
            'token' => 'Your Token',
            'from'  => env( 'SMS_NUMBER' ),
        ],
        // Install: composer require mediaburst/clockworksms
        'clockwork'          => [
            'key' => 'Your clockwork API Key',
        ],
        'linkmobility'       => [
            'url'      => 'http://simple.pswin.com', // Country Wise this may change.
            'username' => env( 'SMS_USERNAME' ),
            'password' => env( 'SMS_PASSWORD' ),
            'from'     => 'Sender name', // sender
        ],
        // Install: composer require melipayamak/php
        'melipayamak'        => [
            'username' => env( 'SMS_USERNAME' ),
            'password' => env( 'SMS_PASSWORD' ),
            'from'     => env( 'SMS_NUMBER' ),
            'flash'    => false,
        ],
        'melipayamakpattern' => [
            'username' => env( 'SMS_USERNAME' ),
            'password' => env( 'SMS_PASSWORD' ),
        ],
        // Install: composer require kavenegar/php
        'kavenegar'          => [
            'apiKey' => env( 'SMS_API_KEY' ),
            'from'   => env( 'SMS_NUMBER' ),
        ],
        'smsir'              => [
            'url'       => 'https://ws.sms.ir/',
            'apiKey'    => env( 'SMS_API_KEY' ),
            'secretKey' => env( 'SMS_SECRET_KEY' ),
            'from'      => env( 'SMS_NUMBER' ),
        ],
        'tsms'               => [
            'url'      => 'http://www.tsms.ir/soapWSDL/?wsdl',
            'username' => env( 'SMS_USERNAME' ),
            'password' => env( 'SMS_PASSWORD' ),
            'from'     => env( 'SMS_NUMBER' ),
        ],
        'farazsms'           => [
            'url'      => '188.0.240.110/services.jspd',
            'username' => env( 'SMS_USERNAME' ),
            'password' => env( 'SMS_PASSWORD' ),
            'from'     => env( 'SMS_NUMBER' ),
        ],
        'farazsmspattern'    => [
            'url'      => 'http://ippanel.com/patterns/pattern',
            'username' => env( 'SMS_USERNAME' ),
            'password' => env( 'SMS_PASSWORD' ),
            'from'     => env( 'SMS_NUMBER' ),
        ],
        'smsgatewayme'       => [
            'apiToken' => 'Your Api Token',
            'from'     => 'Your Default Device ID',
        ],
        'smsgateway24'       => [
            'url'      => 'https://smsgateway24.com/getdata/addsms',
            'token'    => 'Your Api Token',
            'deviceid' => 'Your Default Device ID',
            'from'     => 'Device SIM Slot.  0 or 1', // sim
        ],
        'ghasedak'           => [
            'url'    => 'http://api.iransmsservice.com',
            'apiKey' => env( 'SMS_API_KEY' ),
            'from'   => env( 'SMS_NUMBER' ),
        ],
        // Install: composer require sms77/api
        'sms77'              => [
            'apiKey' => env( 'SMS_API_KEY' ),
            'flash'  => false,
            'from'   => 'Sender name',
        ],
        'sabapayamak'        => [
            'url'             => 'https://api.SabaPayamak.com',
            'username'        => 'Your Sabapayamak Username',
            'password'        => 'Your Sabapayamak Password',
            'from'            => env( 'SMS_NUMBER' ),
            'token_valid_day' => 30,
        ],
        'lsim'               => [
            'username' => 'Your LSIM login',
            'password' => 'Your LSIM password',
            'from'     => 'Your LSIM Sender ID', // sender
        ],
        'rahyabcp'           => [
            'url'      => 'https://p.1000sms.ir/Post/Send.asmx?wsdl',
            'username' => 'Your Rahyabcp login',
            'password' => 'Your Rahyabcp password',
            'from'     => env( 'SMS_NUMBER' ),
            'flash'    => false,
        ],
        'rahyabir'           => [
            'url'             => 'https://api.rahyab.ir',
            'username'        => 'Your Rahyabir Username',
            'password'        => 'Your Rahyabir Password',
            'company'         => 'Your Rahyabir Company',
            'from'            => env( 'SMS_NUMBER' ),
            'token_valid_day' => 1,
        ],
        'd7networks'         => [
            'url'             => 'https://api.d7networks.com',
            'username'        => 'Your D7networks ClientId',
            'password'        => 'Your D7networks clientSecret',
            'originator'      => 'SignOTP',
            'report_url'      => '',
            'token_valid_day' => 1,
        ],
        'hamyarsms'          => [
            'url'      => 'http://payamakapi.ir/SendService.svc?singleWsdl',
            'username' => 'Your Hamyarsms Username',
            'password' => 'Your Hamyarsms Password',
            'from'     => env( 'SMS_NUMBER' ),
            'flash'    => false,
        ],
        'smsapi'             => [
            'url'      => 'http://www.smsapi.si/poslji-sms',
            'username' => 'Your SMSApi Username',
            'password' => 'Your SMSApi Password',
            'from'     => env( 'SMS_NUMBER' ),
            'cc'       => 'Your Default Country Code',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Maps
    |--------------------------------------------------------------------------
    |
    | This is the array of Classes that maps to Drivers above.
    | You can create your own driver if you like and add the
    | config in the drivers array and the class to use for
    | here with the same name. You will have to extend
    | Tzsk\Sms\Abstracts\Driver in your driver.
    |
    */
    'map'     => [
        'sns'                => \Tzsk\Sms\Drivers\Sns::class,
        'textlocal'          => \Tzsk\Sms\Drivers\Textlocal::class,
        'twilio'             => \Tzsk\Sms\Drivers\Twilio::class,
        'smsgateway24'       => \Tzsk\Sms\Drivers\SmsGateway24::class,
        'clockwork'          => \Tzsk\Sms\Drivers\Clockwork::class,
        'linkmobility'       => \Tzsk\Sms\Drivers\Linkmobility::class,
        'melipayamak'        => \Tzsk\Sms\Drivers\Melipayamak::class,
        'melipayamakpattern' => \Tzsk\Sms\Drivers\Melipayamakpattern::class,
        'kavenegar'          => \Tzsk\Sms\Drivers\Kavenegar::class,
        'smsir'              => \Tzsk\Sms\Drivers\Smsir::class,
        'tsms'               => \Tzsk\Sms\Drivers\Tsms::class,
        'farazsms'           => \Tzsk\Sms\Drivers\Farazsms::class,
        'farazsmspattern'    => \Tzsk\Sms\Drivers\Farazsmspattern::class,
        'ghasedak'           => \Tzsk\Sms\Drivers\Ghasedak::class,
        'sms77'              => \Tzsk\Sms\Drivers\Sms77::class,
        'sabapayamak'        => \Tzsk\Sms\Drivers\SabaPayamak::class,
        'lsim'               => \Tzsk\Sms\Drivers\LSim::class,
        'rahyabcp'           => \Tzsk\Sms\Drivers\Rahyabcp::class,
        'rahyabir'           => \Tzsk\Sms\Drivers\Rahyabir::class,
        'd7networks'         => \Tzsk\Sms\Drivers\D7networks::class,
        'hamyarsms'          => \Tzsk\Sms\Drivers\Hamyarsms::class,
        'smsapi'             => \Tzsk\Sms\Drivers\SmsApi::class,
        'log'                => \IracodeCom\FilamentNotification\Drivers\LogDriver::class
    ],
];
