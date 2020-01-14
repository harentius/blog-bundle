<?php

namespace Harentius\BlogBundle\Admin\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PageAdmin extends AbstractPostAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('slug')
            ->add('author')
            ->add('published')
            ->add('publishedAt')
            ->add('metaDescription')
            ->add('metaKeywords')
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('slug', null, [
                'required' => false,
            ])
            ->add('text', TextareaType::class, [
                'attr' => ['class' => 'wysiwyg'],
            ])
            ->add('published', null, [
                'required' => false,
            ])
            ->add('showInMainMenu', null, [
                'required' => false,
            ])
            ->add('publishedAt', DatePickerType::class, [
                'required' => false,
                'format' => 'dd MM y',
            ])
            ->add('author')
            ->add('metaDescription', TextareaType::class, [
                'required' => false,
            ])
            ->add('metaKeywords', TextType::class, [
                'required' => false,
            ])
        ;
    }
}
