<?php

namespace IracodeCom\FilamentNotification\Concerns;

use IracodeCom\FilamentNotification\Filament\Pages\NotificationSettingsPage;

trait CanCustomizePage
{

    /** @var string */
    protected string $page = NotificationSettingsPage::class;

    /**
     * @param string $page
     * @return $this
     */
    public function usingPage( string $page ) : static
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return string
     */
    public function getPage() : string
    {
        return $this->page;
    }

}
