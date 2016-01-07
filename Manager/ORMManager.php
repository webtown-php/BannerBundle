<?php

namespace WebtownPhp\BannerBundle\Manager;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Form\Exception\LogicException;
use WebtownPhp\BannerBundle\Entity\Banner;
use WebtownPhp\BannerBundle\Entity\BannerRepository;
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
     *
     * @return Banner
     */
    public function getBannerTo($placeName, $isMeasured = true)
    {
        if ($banner = $this->doGetBanner($placeName)) {
            $event = new BannerSelectEvent();
            $name = Events::BANNER_SELECT;
        } else {
            $event = new BannerEmptyEvent();
            $name = Events::BANNER_EMPTY;
        }
        $this->dispatcher->dispatch($name, $event);

        if ($event instanceof BannerSelectEvent && $event->getIsMeasured()) {
            $this->measureShowCount($banner);
        }

        return $banner;
    }

    /**
     * @param string $placeName
     *
     * @return Banner
     */
    protected function doGetBanner($placeName)
    {
        $banners = $this->getRepository()->getBannersForPlace($placeName);
        if (! $banners) {
            return null;
        }
        $max = 0;
        foreach ($banners as $banner) {
            $max += $banner->getPriority();
        }
        $rand = rand(0, $max);
        foreach ($banners as $banner) {
            if ($rand <= 0) {
                return $banner;
            }
            $rand -= $banner->getPriority();
        }

        throw new LogicException('Banner select by priority failed.');
    }

    /**
     * Increment view count
     *
     * @param Banner $banner
     */
    public function measureDisplayCount(Banner $banner)
    {
        $this->getRepository()->incrementDisplayCountForBanner($banner);
    }

    /**
     * Increment click count for banner
     *
     * @param Banner $banner
     */
    public function measureClickCount(Banner $banner)
    {
        $this->getRepository()->incrementClickCountForBanner($banner);
    }
    
    /**
     * @return BannerRepository
     */
    protected function getRepository()
    {
        return $this->doctrine->getManager()->getRepository('BannerBundle:Banner');
    }
}
