<?php

namespace IracodeCom\FilamentNotification\Drivers;

use Illuminate\Support\Facades\Log;
use Tzsk\Sms\Contracts\Driver;

class LogDriver extends Driver
{

    /**
     * @return true
     */
    public function send() : true
    {

        Log::build( [
            'driver' => 'single',
            'path'   => storage_path( 'logs/sms.log' ),
        ] )->info(
            $this->body, array_merge( $this->recipients )
        );

        return true;

    }
}
