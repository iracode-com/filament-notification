<?php

namespace IracodeCom\FilamentNotification\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action as ComponentsAction;
use Filament\Forms\Components\Grid;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use IracodeCom\FilamentNotification\FilamentNotificationPlugin;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class NotificationSettingsPage extends Page implements HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $telegram_chat_id;
    public $bale_chat_id;
    public $notify_bale;
    public $notify_telegram;
    public $notify_sms;

    /** @var string|null */
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    /** @var string|null  */
    protected static ?string $slug = 'notification-settings';

    /** @var string */
    protected static string $view = 'iracode-filament-notification::filament.pages.notification-settings';

    /**
     * @return bool
     */
    public static function shouldRegisterNavigation() : bool
    {
        return false;
    }

    public function getTitle() : string | Htmlable
    {
        return __( 'iracode-filament-notification::pages.title' );
    }

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
            'prefers_bale'     => $form[ 'notify_bale' ],
            'prefers_telegram' => $form[ 'notify_telegram' ],
            'prefers_sms'      => $form[ 'notify_sms' ],
            'bale_chat_id'     => $form[ 'bale_chat_id' ],
        ] )->save();

        Notification::make()
                    ->body( __( 'iracode-filament-notification::notification.save' ) )
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
                  ->label( __( 'filament-actions::edit.single.modal.actions.save.label' ) )
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
                                           ->label( __( 'iracode-filament-notification::label.NotifyBale' ) )
                                           ->default( false ),

                    Forms\Components\Toggle::make( 'notify_telegram' )
                                           ->label( __( 'iracode-filament-notification::label.NotifyTelegram' ) )
                                           ->default( false ),

                    Forms\Components\Toggle::make( 'notify_sms' )
                                           ->label( __( 'iracode-filament-notification::label.NotifySMS' ) )
                                           ->default( false ),

                ] )
                ->columns( FilamentNotificationPlugin::get()->getGridColumnNotify() )
                ->columnSpan( FilamentNotificationPlugin::get()->getSectionColumnSpan() ),

            Grid::make()
                ->schema( [

                    Forms\Components\TextInput::make( 'telegram_chat_id' )
                                              ->label( __( 'iracode-filament-notification::label.TelegramChatID.label' ) )
                                              ->hint( __( 'iracode-filament-notification::label.TelegramChatID.hint' ) )
                                              ->suffixAction(
                                                  ComponentsAction::make( 'telegram' )
                                                                  ->url( $this->getTelegramLink() )
                                                                  ->icon( 'heroicon-o-arrow-top-right-on-square' )
                                              )
                                              ->disabled(),

                    Forms\Components\TextInput::make( 'bale_chat_id' )
                                              ->label( __( 'iracode-filament-notification::label.BaleChatID' ) )
                                              ->required(),

                ] )
                ->columns( FilamentNotificationPlugin::get()->getGridColumnConfig() )
                ->columnSpan( FilamentNotificationPlugin::get()->getSectionColumnSpan() )

        ];
    }

}
