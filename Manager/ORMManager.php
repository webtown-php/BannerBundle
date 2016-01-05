<?php

namespace WebtownPhp\BannerBundle\Manager;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use WebtownPhp\BannerBundle\Entity\Banner;
use WebtownPhp\BannerBundle\Event\BannerEmptyEvent;
use WebtownPhp\BannerBundle\Event\BannerSelectEvent;
use WebtownPhp\BannerBundle\Event\Events;

class ORMManager implements ManagerInterface
{
    /**
     * @var RegistryInterface
     */
    protected $doctrine;

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * ORMManager constructor.
     *
     * @param RegistryInterface $doctrine
     */
    public function __construct(RegistryInterface $doctrine, EventDispatcher $dispatcher)
    {
        $this->doctrine = $doctrine;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Get banner to given place
     *
     * @param string    $placeName  Banner place name
     * @param bool|true $isMeasured Should views be counted
     */
    public function getBannerTo($placeName, $isMeasured = true)
    {
        if ($banner = $this->doGetBanner($placeName))
        {
            $event = new BannerSelectEvent();
            $name = Events::BANNER_SELECT;
        }
        else
        {
            $event = new BannerEmptyEvent();
            $name = Events::BANNER_EMPTY;
        }
        $this->dispatcher->dispatch($name, $event);

        if ($event instanceof BannerSelectEvent)
        {
          if ($event->getIsMeasured())
          {
              $this->measureShowCount($banner);
          }
        }
    }

    /**
     * @param string $placeName
     *
     * @return Banner
     */
    protected function doGetBanner($placeName)
    {
        $em = $this->doctrine->getManager();

        $banners = $em->getRepository('BannerBundle:Banner')->getBannersForPlace($placeName);
        $sum = $em->getRepository('BannerBundle:Banner')->getPrioritySumForPlace($placeName);

        return $this->doGetByPriority($banners, $sum);
    }

    /**
     * Get a random banner by priority
     *
     * @param array $banners
     * @param int   $max
     *
     * @return Banner
     */
    protected function doGetByPriority(array $banners, $max)
    {
        $rand = rand(0, $max);
        foreach ($banners as $banner)
        {
            if ($rand <= 0)
            {
              return $banner;
            }
            $rand -= $banner->getPriority();
        }

        return null;
    }

    /**
     * Increment view count
     *
     * @param Banner $banner
     */
    public function measureDisplayCount(Banner $banner)
    {
        $this->doctrine->getManager()->getRepository('BannerBundle:Banner')->incDisplayCountForBanner($banner);
    }

    /**
     * Increment click count for banner
     *
     * @param Banner $banner
     */
    public function measureClickCount(Banner $banner)
    {
        $this->doctrine->getManager()->getRepository('BannerBundle:Banner')->incClickCountForBanner($banner);
    }
}
