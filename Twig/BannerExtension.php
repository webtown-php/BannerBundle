<?php
namespace WebtownPhp\BannerBundle\Twig;

use WebtownPhp\BannerBundle\Entity\Banner;
use WebtownPhp\BannerBundle\Manager\ManagerInterface;

class BannerExtension extends \Twig_Extension
{
    /**
     * @var ManagerInterface
     */
    protected $manager;

    /**
     * BannerExtension constructor.
     *
     * @param ManagerInterface $manager
     */
    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('render_banner', [$this, 'renderBanner'], [
                'is_safe' => ['html'],
                'needs_environment' => true
            ])
        ];
    }

    /**
     * Render banner for place
     *
     * @param \Twig_Environment $env
     * @param string            $placeName
     * @param string            $templatePath Optional custom template path for existing banner
     *
     * @return string
     */
    public function renderBanner(\Twig_Environment $env, $placeName, $templatePath = null)
    {
        $banner = $this->manager->getBannerTo($placeName);
        $partial = '';

        if (is_null($banner)) {
            $template = 'empty';
        } elseif (is_null($templatePath)) {
            $template = 'banner';
            $partial = "WebtownPhpBannerBundle:partials:{$banner->getTypeName()}_banner.html.twig";
        }

        if (isset($template)) {
            $templatePath = "WebtownPhpBannerBundle:partials:$template.html.twig";
        }

        return $env->render($templatePath, [
            'placeName' => $placeName,
            'banner' => $banner,
            'template' => $partial
        ]);
    }

    public function getName()
    {
        return 'banner_extension';
    }
}
