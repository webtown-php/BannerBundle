<?php

namespace WebtownPhp\BannerBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class BannerEmptyEvent extends Event
{
    protected
        /**
         * Banner place name
         *
         * @var string
         */
        $place
    ;

    /**
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }
}
