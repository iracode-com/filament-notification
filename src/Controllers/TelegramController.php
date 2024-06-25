<?php

namespace IracodeCom\FilamentNotification\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use App\Models\User;

class TelegramController extends Controller
{

    /** @var Api */
    protected Api $telegram;

    /**
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function __construct()
    {
        $this->telegram = new Api( config( 'services.telegram.bot_token' ) );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function webhook( Request $request ) : JsonResponse
    {
        $update = $this->telegram->getWebhookUpdate();

        if ( $update->getMessage() )
        {
            $message = $update->getMessage();
            $chatId  = $message->getChat()->getId();
            $text    = $message->getText();

            if ( str_starts_with( $text, '/start' ) )
            {
                $userId = base64_decode( substr( $text, 7 ) );

                $user = User::find( $userId );
                if ( $user )
                {
                    $user->telegram_chat_id = $chatId;
                    $user->save();

                    $this->telegram->sendMessage( [
                        'chat_id' => $chatId,
                        'text'    => "Your Telegram chat ID has been registered successfully!",
                    ] );
                }
                else
                {
                    $this->telegram->sendMessage( [
                        'chat_id' => $chatId,
                        'text'    => "Invalid user ID.",
                    ] );
                }
            }
        }

        return response()->json( [ 'status' => 'success' ] );
    }

    /**
     * @return JsonResponse
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function setWebhook() : JsonResponse
    {
        $this->telegram->setWebhook( [ 'url' => route( 'telegram.webhook' ) ] );

        return response()->json( [ 'status' => 'Webhook set successfully!' ] );
    }
}
