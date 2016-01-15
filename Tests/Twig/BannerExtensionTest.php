<?php

namespace WebtownPhp\BannerBundle\Tests\Twig;


use WebtownPhp\BannerBundle\Tests\OMTestCase;
use WebtownPhp\BannerBundle\Twig\BannerExtension;

class BannerExtensionTest extends OMTestCase
{
    /**
     * @var BannerExtension
     */
    protected $ext;

    /**
     * @var \Twig_Environment
     */
    protected $twigEnv;

    protected function setUp()
    {
        parent::setUp();

        $this->ext = new BannerExtension($this->bm);

        // empty template
        $templates = [
            "WebtownPhpBannerBundle:partials:empty.html.twig" => 'empty {{ placeName }}'
        ];
        // banner templates
        foreach (array('empty', 'html', 'image', 'flash') as $item) {
            $templates["WebtownPhpBannerBundle:partials:{$item}_banner.html.twig"] = $item.' {{ banner.content|raw }}';
        }
        $templates["WebtownPhpBannerBundle:partials:custom_image.html.twig"] = 'custom {{ banner.content|raw }}';
        $templates["WebtownPhpBannerBundle:partials:banner.html.twig"] = "{% include template with {'banner': banner} %}";
        $loader = new \Twig_Loader_Array($templates);
        $this->twigEnv = new \Twig_Environment($loader, array(
            'cache' => false,
            'debug' => true,
        ));
    }

    public function testRenderImage()
    {
        $this->loadFixtures(['one_img.yml']);
        $render = $this->ext->renderBanner($this->twigEnv, 'foo');
        $this->assertContains('image', $render);
        $this->assertContains('content.jpg', $render);
    }

    public function testRenderImageCustom()
    {
        $this->loadFixtures(['one_img.yml']);
        $render = $this->ext->renderBanner($this->twigEnv, 'foo', 'WebtownPhpBannerBundle:partials:custom_image.html.twig');
        $this->assertContains('custom', $render);
        $this->assertContains('content.jpg', $render);
    }

    public function testRenderHtml()
    {
        $this->loadFixtures(['one_html.yml']);
        $render = $this->ext->renderBanner($this->twigEnv, 'foo');
        $this->assertContains('html', $render);
        $this->assertContains('Content', $render);
    }

    public function testRenderFlash()
    {
        $this->loadFixtures(['one_flash.yml']);
        $render = $this->ext->renderBanner($this->twigEnv, 'foo');
        $this->assertContains('flash', $render);
        $this->assertContains('content.flv', $render);
    }

    public function testRenderImageCustomTemplate()
    {

    }
    
    public function testRenderEmpty()
    {
        $render = $this->ext->renderBanner($this->twigEnv, 'foo');
        $this->assertContains('foo', $render);
    }
}
