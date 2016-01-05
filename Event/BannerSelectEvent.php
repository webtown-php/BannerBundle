<?php

namespace WebtownPhp\BannerBundle\Event;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Event;
use WebtownPhp\BannerBundle\Entity\Banner;

class BannerSelectEvent extends Event
{
    protected
        /**
         * Banner place name
         *
         * @var string
         */
        $place,

        /**
         * Banner entity
         *
         * @var Banner
         */
        $banner,

        /**
         * @var EntityManagerInterface
         */
        $entityManager,

        /**
         * should banner view be counted
         *
         * @var bool
         */
        $isMeasured
    ;

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
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
     */
    public function setIsMeasured($isMeasured)
    {
        $this->isMeasured = $isMeasured;
    }
}
