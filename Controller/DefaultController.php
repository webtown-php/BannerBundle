<?php

namespace WebtownPhp\BannerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WebtownPhpBannerBundle:Default:index.html.twig');
    }
}
