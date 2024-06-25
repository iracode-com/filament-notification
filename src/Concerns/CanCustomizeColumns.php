<?php

namespace IracodeCom\FilamentNotification\Concerns;

trait CanCustomizeColumns
{

    /** @var int|string|array */
    protected int | string | array $gridColumnNotify = 3;

    /** @var int|string|array */
    protected int | string | array $gridColumnConfig = 2;

    /** @var int|string|array */
    protected int | string | array $sectionColumnSpan = 'full';

    /**
     * @param array|int|string $gridColumnNotify
     * @return $this
     */
    public function setGridColumnNotify( array | int | string $gridColumnNotify ) : static
    {
        $this->gridColumnNotify = $gridColumnNotify;
        return $this;
    }

    /**
     * @return array|int|string
     */
    public function getGridColumnNotify() : array | int | string
    {
        return $this->gridColumnNotify;
    }

    /**
     * @param array|int|string $sectionColumnSpan
     * @return $this
     */
    public function setSectionColumnSpan( array | int | string $sectionColumnSpan ) : static
    {
        $this->sectionColumnSpan = $sectionColumnSpan;
        return $this;
    }

    /**
     * @return array|int|string
     */
    public function getSectionColumnSpan() : array | int | string
    {
        return $this->sectionColumnSpan;
    }

    /**
     * @param array|int|string $gridColumnConfig
     * @return $this
     */
    public function setGridColumnConfig( array | int | string $gridColumnConfig ) : static
    {
        $this->gridColumnConfig = $gridColumnConfig;
        return $this;
    }

    /**
     * @return array|int|string
     */
    public function getGridColumnConfig() : array | int | string
    {
        return $this->gridColumnConfig;
    }

}
