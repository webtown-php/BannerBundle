<?php

namespace WebtownPhp\BannerBundle\Tests;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Tools\SchemaTool;
use Nelmio\Alice\Fixtures;
use Symfony\Bridge\Doctrine\Test\DoctrineTestHelper;
use Symfony\Component\EventDispatcher\EventDispatcher;
use WebtownPhp\BannerBundle\Entity\BannerRepository;
use WebtownPhp\BannerBundle\Manager\ManagerInterface;
use WebtownPhp\BannerBundle\Manager\ORMManager;

/**
 * Test case with DB access
 *
 * @author Zoltan Feher <whitezo@webtown.hu>
 */
class OMTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @var ManagerInterface
     */
    protected $bm;

    /**
     * Test setup
     */
    protected function setUp()
    {
        // setup entity aliases
        $this->em = DoctrineTestHelper::createTestEntityManager();
        $entityManagerNamespaces = $this->em->getConfiguration()->getEntityNamespaces();
        $entityManagerNamespaces['WebtownPhpBannerBundle'] = 'WebtownPhp\BannerBundle\Entity';
        $this->em->getConfiguration()->setEntityNamespaces($entityManagerNamespaces);

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
            $item = __DIR__.'/Resources/DataFixtures/ORM/'.$item;
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
