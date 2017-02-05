<?php

namespace Harentius\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Harentius\BlogBundle\Entity\Article;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Route\RouteCollection;

class AbstractPostAdmin extends Admin
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
        $container = $this->getConfigurationPool()->getContainer();
        // TODO: refactor to entity listener with changeset
        /** @var Article $article */
        $article = $container->get('doctrine.orm.entity_manager')->getRepository('HarentiusBlogBundle:Article')
            ->find($object->getId())
        ;

        if ((!$article || !$article->getIsPublished()) && $object->getIsPublished() && !$object->getPublishedAt()) {
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
