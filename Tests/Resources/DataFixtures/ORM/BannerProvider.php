<?php

namespace WebtownPhp\BannerBundle\Tests\Resources\DataFixtures\ORM;

use Faker\Provider\Base as BaseProvider;

class BannerProvider extends BaseProvider
{
    /**
     * @return string Random job abbreviation title
     */
    public static function futureDate()
    {
        return new \DateTime('+'.rand(2,20).' day');
    }
}
