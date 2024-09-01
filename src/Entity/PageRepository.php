<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[] findAll()
 * @method Page[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends EntityRepository
{
    /**
     * @param string|null $slug
     * @return Page[]
     */
    public function findForMainMenu(?string $slug)
    {
        return $this->createQueryBuilder('p')
            ->where('p.published = :isPublished')
            ->andWhere('p.showInMainMenu = :showInMainMenu')
            ->andWhere('p.slug <> :slug')
            ->setParameter(':isPublished', true)
            ->setParameter(':showInMainMenu', true)
            ->setParameter(':slug', $slug)
            ->orderBy('p.order', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param string|null $slug
     * @return Page|null
     */
    public function findOnePublishedBySlug(?string $slug): ?Page
    {
        return $this->createQueryBuilder('p')
            ->where('p.slug = :slug')
            ->andWhere('p.published = :published')
            ->setParameter('slug', $slug)
            ->setParameter('published', true)
            ->getQuery()
            ->getOneOrNullResult()
         ;
    }
}
