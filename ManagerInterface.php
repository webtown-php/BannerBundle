<?php

namespace WebtownPhp\BannerBundle;


use Symfony\Component\EventDispatcher\EventDispatcher;
use WebtownPhp\BannerBundle\Entity\Banner;
use WebtownPhp\BannerBundle\Event\BannerSelectEvent;
use WebtownPhp\BannerBundle\Event\Events;

class ManagerInterface
{
    /**
     * Get banner to given place
     *
     * @param string    $placeName  Banner place name
     * @param bool|true $isMeasured Should views be counted
     */
    public function getBannerTo($placeName)
    {
        $dispatcher = new EventDispatcher();

        $banner = $this->dogetBannerTo($placeName);

        $event = new BannerSelectEvent();
        $name = Events::BANNER_SELECT;
        //$event = new BannerEmptyEvent();
        //$name = Events::BANNER_EMPTY;

        $dispatcher->dispatch($name, $event);
        if ($event instanceof BannerSelectEvent)
        {
          if ($event->getIsMeasured())
          {
              $this->measureShowCount($banner);
          }
        }
    }

    /**
     * Count views
     *
     * @param Banner $banner
     */
    public function measureShowCount(Banner $banner)
    {
        
    }

    /**
     * @param Banner $banner
     */
    public function measureFollowCount(Banner $banner)
    {

    }


}
