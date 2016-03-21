<?php

namespace WebtownPhp\BannerBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

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
                    'banner_preview' => array(
                        'template' => 'WebtownPhpBannerBundle:Admin:list_action_banner_preview.html.twig'
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
        $formMapper
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
        $collection->add('banner_preview', $this->getRouterIdParameter().'/preview');
        $collection->add('toggle', $this->getRouterIdParameter().'/toggle');
    }
}
