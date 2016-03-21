<?php

namespace WebtownPhp\BannerBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BannerAdminController extends CRUDController
{
    public function bannerPreviewAction()
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        return $this->render('WebtownPhpBannerBundle:Admin:banner_preview.html.twig');
    }

    /**
     * Start/stop banner
     */
    public function ToggleAction()
    {
        if (!$object = $this->admin->getSubject()) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $object->toggle();
        $em = $this->getDoctrine()->getManager();
        $em->persist($object);
        $em->flush();

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
