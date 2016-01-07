<?php

namespace WebtownPhp\BannerBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class BannerEmptyEvent extends Event
{
    /**
     * Banner place name
     *
     * @var string
     */
    protected $place;

    /**
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }
}
