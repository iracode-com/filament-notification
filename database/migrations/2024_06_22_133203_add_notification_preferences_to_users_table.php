<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table( config( 'iracode-filament-notification.table', 'users' ), function ( Blueprint $table ) {
            $table->boolean( 'prefers_telegram' )->default( false );
            $table->boolean( 'prefers_sms' )->default( false );
            $table->boolean( 'prefers_bale' )->default( false );
            $table->string( 'telegram_chat_id', 30 )->nullable();
            if ( config( 'iracode-filament-notification.has_column_phone', false ) )
                $table->string( 'phone', 20 )->nullable();
            $table->string( 'bale_chat_id', 30 )->nullable();
        } );
    }

    public function down()
    {
        Schema::table( config( 'iracode-filament-notification.table', 'users' ), function ( Blueprint $table ) {

            $table->dropColumn( 'prefers_telegram' );
            $table->dropColumn( 'prefers_sms' );
            $table->dropColumn( 'prefers_bale' );

            $table->dropColumn( 'telegram_chat_id' );
            $table->dropColumn( 'bale_chat_id' );
            if ( config( 'iracode-filament-notification.has_column_phone', false ) )
                $table->dropColumn( 'phone' );

        } );
    }

};
