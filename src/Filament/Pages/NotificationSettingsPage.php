<?php

namespace IracodeCom\FilamentNotification\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action as ComponentsAction;
use Filament\Forms\Components\Grid;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use IracodeCom\FilamentNotification\FilamentNotificationPlugin;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class NotificationSettingsPage extends Page implements HasForms
{
    use Forms\Concerns\InteractsWithForms;

    /** @var string|null */
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    /** @var string */
//    protected static string $view = 'filament-notification::filament.pages.notification-settings';
    protected static string $view = 'filament.pages.notification-settings';

    /**
     * @return bool
     */
    public static function shouldRegisterNavigation() : bool
    {
        return false;
    }

    public $telegram_chat_id;
    public $bale_chat_id;
    public $notify_bale;
    public $notify_telegram;
    public $notify_sms;

    /**
     * @return void
     */
    public function mount() : void
    {
        $this->form->fill( [
            'telegram_chat_id' => auth()->user()->telegram_chat_id,
            'bale_chat_id'     => auth()->user()->bale_chat_id,
            'notify_bale'      => auth()->user()->prefers_bale,
            'notify_telegram'  => auth()->user()->prefers_telegram,
            'notify_sms'       => auth()->user()->prefers_sms,
        ] );
    }

    /**
     * @return true
     */
    public function save() : true
    {
        $form = $this->form->getState();

        Auth::user()->fill( [
            'notify_bale'     => $form[ 'notify_bale' ],
            'notify_telegram' => $form[ 'notify_telegram' ],
            'notify_sms'      => $form[ 'notify_sms' ],
            'bale_chat_id'    => $form[ 'bale_chat_id' ],
        ] )->save();

        Notification::make()
                    ->body( 'Notification settings updated successfully!' )
                    ->success()
                    ->send()
        ;

        return true;
    }

    /**
     * @return string
     */
    public function getTelegramLink() : string
    {
        try
        {
            $telegram            = new Api( env( 'TELEGRAM_BOT_TOKEN' ) );
            $response            = $telegram->getMe();
            $telegramBotUsername = $response->getUsername();
        }
        catch ( \Exception )
        {
            $telegramBotUsername = '';
        }
        return "https://t.me/$telegramBotUsername?start=" . base64_encode( Auth::id() );
    }

    /**
     * @return array|Action[]|\Filament\Actions\ActionGroup[]
     */
    protected function getActions() : array
    {
        return [
            Action::make( 'save' )
                  ->label( 'Save Bale Chat ID' )
                  ->action( 'save' )
                  ->requiresConfirmation(),
        ];
    }

    /**
     * @return array|Forms\Components\Component[]
     * @throws TelegramSDKException
     */
    protected function getFormSchema() : array
    {
        return [

            Grid::make()
                ->schema( [


                    Forms\Components\Toggle::make( 'notify_bale' )
                                           ->label( 'Notify via Bale' )
                                           ->default( false ),

                    Forms\Components\Toggle::make( 'notify_telegram' )
                                           ->label( 'Notify via Telegram' )
                                           ->default( false ),

                    Forms\Components\Toggle::make( 'notify_sms' )
                                           ->label( 'Notify via SMS' )
                                           ->default( false ),

                ] )
                ->columns( FilamentNotificationPlugin::get()->getGridColumnNotify() )
                ->columnSpan( FilamentNotificationPlugin::get()->getSectionColumnSpan() ),

            Grid::make()
                ->schema( [

                    Forms\Components\TextInput::make( 'telegram_chat_id' )
                                              ->label( 'Telegram Chat ID' )
                                              ->hint( 'To register your Telegram Chat ID, click the bottom below:' )
                                              ->suffixAction(
                                                  ComponentsAction::make( 'telegram' )
                                                                  ->url( $this->getTelegramLink() )
                                                                  ->icon( 'heroicon-o-arrow-top-right-on-square' )
                                              )
                                              ->disabled(),

                    Forms\Components\TextInput::make( 'bale_chat_id' )
                                              ->label( 'Bale Chat ID' )
                                              ->required(),

                ] )
                ->columns( FilamentNotificationPlugin::get()->getGridColumnConfig() )
                ->columnSpan( FilamentNotificationPlugin::get()->getSectionColumnSpan() )

        ];
    }

}
