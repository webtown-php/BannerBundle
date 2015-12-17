<?php
namespace WebtownPhp\BannerBundle\Tests\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use WebtownPhp\BannerBundle\DependencyInjection\WebtownPhpBannerExtension;

/**
 * Created by PhpStorm.
 * User: whitezo
 * Date: 15. 12. 17.
 * Time: 15:09
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * @var WebtownPhpBannerExtension
     */
    protected $extension;

    /**
     * Test setup
     */
    protected function setUp()
    {
        $this->extension = new WebtownPhpBannerExtension();
        $this->container = new ContainerBuilder();

        $this->container->registerExtension($this->extension);
    }

    public function testEmpty()
    {
        $this->loadConfiguration($this->container, 'empty.yml');
        $this->container->compile();
    }

    public function testOneCustomSize()
    {
        $this->loadConfiguration($this->container, 'one_custom_size.yml');
        $this->container->compile();

        $this->assertEquals(100, $this->container->getParameter('webtown_php_banner')['custom_size']['wide']['width']);
        $this->assertEquals(10, $this->container->getParameter('webtown_php_banner')['custom_size']['wide']['height']);
    }

    public function testMoreCustomSize()
    {
        $this->loadConfiguration($this->container, 'more_custom_size.yml');
        $this->container->compile();

        $this->assertEquals(true, isset($this->container->getParameter('webtown_php_banner')['custom_size']['wide']));
        $this->assertEquals(true, isset($this->container->getParameter('webtown_php_banner')['custom_size']['tall']));
    }

    public function testOnePlace()
    {
        $this->loadConfiguration($this->container, 'one_place.yml');
        $this->container->compile();

        $this->assertEquals(true, isset($this->container->getParameter('webtown_php_banner')['place']['top']));
        $this->assertEquals(false, $this->container->getParameter('webtown_php_banner')['place']['top']['flash']);
    }

    public function testMorePlace()
    {
        $this->loadConfiguration($this->container, 'more_place.yml');
        $this->container->compile();

        $this->assertEquals(true, isset($this->container->getParameter('webtown_php_banner')['place']['top']));
        $this->assertEquals(true, isset($this->container->getParameter('webtown_php_banner')['place']['left']));
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $resource
     */
    protected function loadConfiguration(ContainerBuilder $container, $resource)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/configs'));
        $loader->load($resource);
    }
}
