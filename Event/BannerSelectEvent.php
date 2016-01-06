<?php

namespace WebtownPhp\BannerBundle\Event;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Event;
use WebtownPhp\BannerBundle\Entity\Banner;

class BannerSelectEvent extends Event
{
    /**
     * Banner place name
     *
     * @var string
     */
    protected $place;

    /**
     * Banner entity
     *
     * @var Banner
     */
    protected $banner;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * should banner view be counted
     *
     * @var bool
     */
    protected $isMeasured;

    /**
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @return Banner
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManagerInterface $entityManager
     *
     * @return BannerSelectEvent
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsMeasured()
    {
        return $this->isMeasured;
    }

    /**
     * @param bool $isMeasured
     *
     * @return BannerSelectEvent
     */
    public function setIsMeasured($isMeasured)
    {
        $this->isMeasured = $isMeasured;

        return $this;
    }
}
