<?php
namespace WebtownPhp\BannerBundle\Tests\Entity;

use Doctrine\ORM\Tools\SchemaTool;
use Nelmio\Alice\Fixtures;
use Symfony\Bridge\Doctrine\Test\DoctrineTestHelper;
use Symfony\Component\EventDispatcher\EventDispatcher;
use WebtownPhp\BannerBundle\Entity\BannerRepository;
use WebtownPhp\BannerBundle\Manager\ORMManager;

/**
 * Class BannerTest
 *
 * @author Zoltan Feher <whitezo@webtown.hu>
 */
class BannerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @var ORMManager
     */
    protected $bm;

    /**
     * Test setup
     */
    protected function setUp()
    {
        // setup entity aliases
        $this->em = DoctrineTestHelper::createTestEntityManager();
        $a = $this->em->getConfiguration()->getEntityNamespaces();
        $a['WebtownPhpBannerBundle'] = 'WebtownPhp\BannerBundle\Entity';
        $this->em->getConfiguration()->setEntityNamespaces($a);

        // setup schema
        $schemaTool = new SchemaTool($this->em);
        $classes = [];
        foreach ($this->getEntities() as $entityClass) {
            $classes[] = $this->em->getClassMetadata($entityClass);
        }
        try {
            $schemaTool->dropSchema($classes);
        } catch (\Exception $e) {
        }
        try {
            $schemaTool->createSchema($classes);
        } catch (\Exception $e) {
        }

        $registry = \Mockery::mock('Doctrine\Bundle\DoctrineBundle\Registry');
        $registry->shouldReceive('getManager')->andReturn($this->em);

        $this->bm = new ORMManager($registry, new EventDispatcher());
    }

    protected function tearDown() {
        \Mockery::close();
    }

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

    protected function getEntities()
    {
        return [
            'WebtownPhp\BannerBundle\Entity\Banner',
        ];
    }

    /**
     * Load the fixtures
     *
     * @param array $fixtures additional fixtures to load
     */
    protected function loadFixtures(array $fixtures = array())
    {
        foreach ($fixtures as &$item)
        {
            $item = __DIR__.'/../Resources/DataFixtures/ORM/'.$item;
        }
        Fixtures::load($fixtures, $this->em, array(
            'providers' => array(
                'WebtownPhp\BannerBundle\Tests\Resources\DataFixtures\ORM\BannerProvider'
            )
        ));
    }

    /**
     * @return BannerRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository('WebtownPhp\BannerBundle\Entity\Banner');
    }
}
