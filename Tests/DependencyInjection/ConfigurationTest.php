<?php
namespace WebtownPhp\BannerBundle\Tests\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use WebtownPhp\BannerBundle\DependencyInjection\Configuration;
use WebtownPhp\BannerBundle\DependencyInjection\WebtownPhpBannerExtension;

/**
 * Class ConfigurationTest
 *
 * @author Zoltan Feher <whitezo@webtown.hu>
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
        $this->setExpectedException(
            'Symfony\Component\Config\Definition\Exception\InvalidConfigurationException',
            'The child node "db_driver" at path "webtown_php_banner" must be configured.'
        );
        $this->loadConfiguration('empty.yml');
    }

    public function testWrongDbDriver()
    {
        $this->setExpectedExceptionRegExp(
            'Symfony\Component\Config\Definition\Exception\InvalidConfigurationException',
            '/The value "\w+" is not allowed.*/'
        );
        $this->loadConfiguration('wrong_db_driver.yml');
    }

    public function testWrongCustomSize()
    {
        $this->setExpectedExceptionRegExp(
            'Symfony\Component\Config\Definition\Exception\InvalidConfigurationException',
            '/The child node "height".*must be configured./'
        );
        $this->loadConfiguration('wrong_custom_size.yml');
    }

    public function testWrongPlaceLabel()
    {
        $this->setExpectedExceptionRegExp(
            'Symfony\Component\Config\Definition\Exception\InvalidConfigurationException',
            '/The child node "label".*must be configured./'
        );
        $this->loadConfiguration('wrong_place_label.yml');
    }

    public function testWrongPlaceSize()
    {
        $this->setExpectedExceptionRegExp(
            'Symfony\Component\Config\Definition\Exception\InvalidConfigurationException',
            '/The child node "size".*must be configured./'
        );
        $this->loadConfiguration('wrong_place_size.yml');
    }

    public function testOneCustomSize()
    {
        $this->loadConfiguration('one_custom_size.yml');

        $this->assertEquals('orm', $this->container->getParameter('webtown_php_banner')['db_driver']);
        $this->assertEquals(100, $this->container->getParameter('webtown_php_banner')['custom_size']['wide']['width']);
        $this->assertEquals(10, $this->container->getParameter('webtown_php_banner')['custom_size']['wide']['height']);
    }

    public function testMoreCustomSize()
    {
        $this->loadConfiguration('more_custom_size.yml');

        $this->assertEquals(true, isset($this->container->getParameter('webtown_php_banner')['custom_size']['wide']));
        $this->assertEquals(true, isset($this->container->getParameter('webtown_php_banner')['custom_size']['tall']));
    }

    public function testOnePlace()
    {
        $this->loadConfiguration('one_place.yml');

        $this->assertEquals(true, isset($this->container->getParameter('webtown_php_banner')['place']['top']));
        $this->assertEquals(false, $this->container->getParameter('webtown_php_banner')['place']['top']['flash']);
    }

    public function testMorePlace()
    {
        $this->loadConfiguration('more_place.yml');

        $this->assertEquals(true, isset($this->container->getParameter('webtown_php_banner')['place']['top']));
        $this->assertEquals(true, isset($this->container->getParameter('webtown_php_banner')['place']['left']));
    }

    /**
     * Load yaml config
     *
     * @param string $resource
     */
    protected function loadConfiguration($resource)
    {
        $this->container->reset();
        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__.'/../Resources/configs'));
        $loader->load($resource);
        $this->container->compile();

        // load current config
        $p = $this->container->getParameterBag()->all();
        $params = array();
        if (is_array($p))
        {
            $params = $p;
        }
        $configuration = new Configuration();
        $proc = new Processor();
        $proc->processConfiguration($configuration, $params);
    }
}
