<?php

namespace Harentius\BlogBundle\Admin\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Harentius\BlogBundle\Entity\Article;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class AbstractPostAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        /** @var Article $object */
        if ($object->isPublished() && !$object->getPublishedAt()) {
            $object->setPublishedAt(new \DateTime());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        /** @var Article $object */
        /** @var EntityManagerInterface $em */
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');
        /** @var array $storedArticle */
        $originalArticleData = $em->getUnitOfWork()->getOriginalEntityData($object);

        if (!$originalArticleData['published'] && $object->isPublished() && !$object->getPublishedAt()) {
            $object->setPublishedAt(new \DateTime());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);
        $alias = $query->getRootAliases()[0];
        $query
            ->orderBy($alias . '.published', 'ASC')
            ->addOrderBy($alias . '.publishedAt', 'DESC')
        ;

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('browse', 'browse/{type}', [], [], [
            'expose' => true,
        ]);
    }
}
