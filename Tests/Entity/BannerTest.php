<?php
namespace WebtownPhp\BannerBundle\Tests\Entity;

use WebtownPhp\BannerBundle\Tests\OMTestCase;

/**
 * Class BannerTest
 *
 * @author Zoltan Feher <whitezo@webtown.hu>
 */
class BannerTest extends OMTestCase
{
    public function testOneActive()
    {
        $this->loadFixtures(['one_active_banner.yml']);
        $this->assertNotNull($this->bm->getBannerTo('foo'));
    }

    public function testOneMaxReached()
    {
        $this->loadFixtures(['one_max_reached.yml']);
        $this->assertNull($this->bm->getBannerTo('foo'));
    }

    public function testOneInactive()
    {
        $this->loadFixtures(['one_inactive.yml']);
        $this->assertNull($this->bm->getBannerTo('foo'));
    }

    public function testOneEnded()
    {
        $this->loadFixtures(['one_ended.yml']);
        $this->assertNull($this->bm->getBannerTo('foo'));
    }

    public function testOneNotStarted()
    {
        $this->loadFixtures(['one_not_started.yml']);
        $this->assertNull($this->bm->getBannerTo('foo'));
    }

    public function testEightInactive()
    {
        $this->loadFixtures([
            'one_max_reached.yml',
            'one_max_reached.yml',
            'one_inactive.yml',
            'one_inactive.yml',
            'one_ended.yml',
            'one_ended.yml',
            'one_not_started.yml',
            'one_not_started.yml',
        ]);
        $this->assertNull($this->bm->getBannerTo('foo'));
    }

    public function testEightInactive1Active2Views()
    {
        $this->loadFixtures([
            'one_max_reached.yml',
            'one_max_reached.yml',
            'one_inactive.yml',
            'one_inactive.yml',
            'one_ended.yml',
            'one_ended.yml',
            'one_not_started.yml',
            'one_not_started.yml',
            'one_active_2_views_left.yml',
        ]);
        $this->assertNotNull($this->bm->getBannerTo('foo', true));
        $this->assertNotNull($this->bm->getBannerTo('foo', true));
        $this->assertNull($this->bm->getBannerTo('foo', true));
    }
}
