<?php

namespace Harentius\BlogBundle\Admin\Admin;

use Doctrine\Common\Cache\CacheProvider;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleAdmin extends AbstractPostAdmin
{
    /**
     * @var CacheProvider
     */
    private $controllersCache;

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        parent::prePersist($object);
        $this->clearCache();
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        parent::preUpdate($object);
        $this->clearCache();
    }

    /**
     * @param CacheProvider $controllersCache
     */
    public function setControllerCache(CacheProvider $controllersCache)
    {
        $this->controllersCache = $controllersCache;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('slug')
            ->add('category')
            ->add('tags')
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
            ->add('category')
            ->add('tags', ModelAutocompleteType::class, [
                'attr' => [
                    'class' => 'tags',
                ],
                'minimum_input_length' => 2,
                'required' => false,
                'property' => 'name',
                'multiple' => 'true',
            ])
            ->add('text', TextareaType::class, [
                'attr' => ['class' => 'wysiwyg'],
            ])
            ->add('published', null, [
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

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('text')
            ->add('category')
        ;
    }

    /**
     *
     */
    private function clearCache()
    {
        $this->controllersCache->deleteAll();
        $container = $this->getConfigurationPool()->getContainer();
//        $container->get('harentius_blog.router.category_slug_provider')->clearAll();
//        $container->get('harentius_blog.controller.feed_cache')->deleteAll();
    }
}
