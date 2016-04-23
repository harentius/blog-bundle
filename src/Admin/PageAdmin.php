<?php

namespace Harentius\BlogBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PageAdmin extends AbstractPostAdmin
{
    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('slug')
            ->add('author')
            ->add('isPublished')
            ->add('publishedAt')
            ->add('metaDescription')
            ->add('metaKeywords')
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('slug', null, [
                'required' => false,
            ])
            ->add('text', 'textarea', [
                'attr' => ['class' => 'blog-page-edit'],
            ])
            ->add('isPublished', null, [
                'required' => false,
            ])
            ->add('showInMainMenu', null, [
                'required' => false,
            ])
            ->add('publishedAt', 'sonata_type_date_picker', [
                'required' => false,
                'format' => 'dd MM y',
            ])
            ->add('author')
            ->add('metaDescription', 'textarea', [
                'required' => false,
            ])
            ->add('metaKeywords', 'text', [
                'required' => false,
            ])
        ;
    }
}
