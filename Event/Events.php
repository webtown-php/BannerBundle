<?php

namespace WebtownPhp\BannerBundle\Event;

final class Events
{
    const
        /**
         * event thrown each time a banner is selected for a place
         *
         * The event listener receives an
         * WebtownPhp\BannerBundle\Event\BannerSelectEvent instance.
         *
         * @var string
         * @see WebtownPhp\BannerBundle\Event\BannerSelectEvent
         */
        BANNER_SELECT = 'webtown_php.banner.select',

        /**
         * event thrown each time a banner cannot be found for a place
         *
         * The event listener receives an
         * WebtownPhp\BannerBundle\Event\BannerEmptyEvent instance.
         *
         * @var string
         * @see WebtownPhp\BannerBundle\Event\BannerEmptyEvent
         */
        BANNER_EMPTY  = 'webtown_php.banner.empty'
    ;
}
