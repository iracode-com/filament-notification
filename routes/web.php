<?php


use Illuminate\Support\Facades\Route;
use IracodeCom\FilamentNotification\Controllers\TelegramController;


Route::post( 'telegram/webhook', [ TelegramController::class, 'webhook' ] )->name( 'telegram.webhook' );
Route::get( 'telegram/set-webhook', [ TelegramController::class, 'setWebhook' ] );
