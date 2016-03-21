<?php

namespace WebtownPhp\BannerBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use WebtownPhp\BannerBundle\Entity\Banner;

class BannerAdmin extends Admin
{
    protected $translationDomain = 'WebtownPhpBannerBundle';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('target')
            ->add('place')
            ->add('isFlashEnabled')
            ->add('isImageEnabled')
            ->add('isHtmlEnabled')
            ->add('priority')
            ->add('maxDisplayCount')
            ->add('startAt')
            ->add('endAt')
            ->add('displayCount')
            ->add('clickCount')
            ->add('isActive')
            ->add('content')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('status', null, [
                'label' => '',
                'template' => 'WebtownPhpBannerBundle:Admin:list_item_status.html.twig'
            ])
            ->add('name')
            ->add('place')
            ->add('contentTypes', null, [
                'template' => 'WebtownPhpBannerBundle:Admin:list_item_content_types.html.twig'
            ])
            ->add('startAt')
            ->add('endAt')
            ->add('priority')
            ->add('maxDisplayCount')
            ->add('displayCount')
            ->add('clickCount')
            ->add('clickThroughRate')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'preview' => array(
                        'template' => 'WebtownPhpBannerBundle:Admin:list_action_preview.html.twig'
                    ),
                    'toggle' => array(
                        'template' => 'WebtownPhpBannerBundle:Admin:list_action_toggle.html.twig'
                    ),
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $conf      = $container->getParameter('webtown_php_banner');
        $places    = [];
        if (isset($conf['place']))
        {
            foreach ($conf['place'] as $key => $data)
            {
                $places[$data['label']] = $key;
            }
        }
        $formMapper
            ->add('name')
            ->add('target')
            ->add('place', 'choice', array(
                'choices' => $places,
                'choice_translation_domain' => 'WebtownPhpBannerBundle'
            ))
            ->add('priority')
            ->add('maxDisplayCount')
            ->add('startAt')
            ->add('endAt')
            ->add('isActive')
            ->add('contentType', 'choice', array(
                'choices' => Banner::getContentTypeChoices(),
                'choice_translation_domain' => 'WebtownPhpBannerBundle'
            ))
            ->add('content')
        ;
        $banner = $this->getSubject();
        if (! is_null($banner->getId())) {
            $help = $container->get('translator')->trans(
                'max_display_count_help',
                ['%current%' => $banner->getDisplayCount()],
                'WebtownPhpBannerBundle');
            $formMapper->addHelp('maxDisplayCount', $help);
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('target')
            ->add('place')
            ->add('isFlashEnabled')
            ->add('isImageEnabled')
            ->add('isHtmlEnabled')
            ->add('priority')
            ->add('maxDisplayCount')
            ->add('startAt')
            ->add('endAt')
            ->add('displayCount')
            ->add('clickCount')
            ->add('isActive')
            ->add('content')
        ;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('preview', $this->getRouterIdParameter().'/preview');
        $collection->add('toggle', $this->getRouterIdParameter().'/toggle');
    }
}
