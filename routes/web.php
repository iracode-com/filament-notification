<?php


use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use IracodeCom\FilamentNotification\Controllers\TelegramController;


Route::withoutMiddleware( [ ValidateCsrfToken::class, VerifyCsrfToken::class ] )
     ->post( 'telegram/webhook', [ TelegramController::class, 'webhook' ] )
     ->name( 'telegram.webhook' )
;
Route::get( 'telegram/set-webhook', [ TelegramController::class, 'setWebhook' ] );
