<?php

namespace WebtownPhp\BannerBundle\Manager;

use WebtownPhp\BannerBundle\Entity\Banner;

interface ManagerInterface
{
    /**
     * Get banner to given place
     *
     * @param string    $placeName  Banner place name
     * @param bool|true $isMeasured Should views be counted
     */
    public function getBannerTo($placeName, $isMeasured = true);

    /**
     * Count views
     *
     * @param Banner $banner
     */
    public function measureDisplayCount(Banner $banner);

    /**
     * @param Banner $banner
     */
    public function measureClickCount(Banner $banner);
}
