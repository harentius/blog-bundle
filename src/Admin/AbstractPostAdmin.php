<?php

namespace Harentius\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Harentius\BlogBundle\Entity\Article;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Route\RouteCollection;

class AbstractPostAdmin extends Admin
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function setEntityManager($em)
    {
        $this->em = $em;
    }

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
        // TODO: refactor to entity listener with changeset
        /** @var Article $object*/
        $article = $this->em->getRepository('HarentiusBlogBundle:Article')->find($object->getId());

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
