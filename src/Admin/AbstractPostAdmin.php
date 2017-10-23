<?php

namespace Harentius\BlogBundle\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Harentius\BlogBundle\Entity\Article;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Route\RouteCollection;

class AbstractPostAdmin extends AbstractAdmin
{
    /**
     * {@inheritDoc}
     */
    public function prePersist($object)
    {
        /** @var Article $object*/
        if ($object->getIsPublished() && !$object->getPublishedAt()) {
            $object->setPublishedAt(new \DateTime());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate($object)
    {
        /** @var Article $object*/
        /** @var EntityManagerInterface $em */
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');
        /** @var array $storedArticle */
        $originalArticleData = $em->getUnitOfWork()->getOriginalEntityData($object);

        if (!$originalArticleData['isPublished'] && $object->getIsPublished() && !$object->getPublishedAt()) {
            $object->setPublishedAt(new \DateTime());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);
        $alias = $query->getRootAliases()[0];
        $query
            ->orderBy($alias . '.isPublished', 'ASC')
            ->addOrderBy($alias . '.publishedAt', 'DESC')
        ;

        return $query;
    }

    /**
     * {@inheritDoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('upload', 'upload');
        $collection->add('browse', 'browse/{type}');
    }
}
