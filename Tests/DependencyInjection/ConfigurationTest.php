<?php
namespace WebtownPhp\BannerBundle\Tests\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;
use WebtownPhp\BannerBundle\DependencyInjection\Configuration;

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

    protected $config = array();

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

        $this->assertEquals('orm', $this->config['db_driver']);
        $this->assertEquals(100, $this->config['custom_size']['wide']['width']);
        $this->assertEquals(10, $this->config['custom_size']['wide']['height']);
    }

    public function testMoreCustomSize()
    {
        $this->loadConfiguration('more_custom_size.yml');

        $this->assertEquals(true, isset($this->config['custom_size']['wide']));
        $this->assertEquals(true, isset($this->config['custom_size']['tall']));
    }

    public function testOnePlace()
    {
        $this->loadConfiguration('one_place.yml');

        $this->assertEquals(true, isset($this->config['place']['top']));
        $this->assertEquals(false, $this->config['place']['top']['flash']);
    }

    public function testMorePlace()
    {
        $this->loadConfiguration('more_place.yml');

        $this->assertEquals(true, isset($this->config['place']['top']));
        $this->assertEquals(true, isset($this->config['place']['left']));
    }

    /**
     * Load yaml config
     *
     * @param string $resource
     */
    protected function loadConfiguration($resource)
    {
        $yaml = new Parser();
        $params = (array)$yaml->parse(file_get_contents(__DIR__.'/../Resources/configs/'.$resource));
        $params = isset($params['parameters']) ? $params['parameters'] : array();
        $configuration = new Configuration();
        $proc = new Processor();
        $this->config = $proc->processConfiguration($configuration, $params);
    }
}
