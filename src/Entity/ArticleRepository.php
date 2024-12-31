<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[] findAll()
 * @method Article[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends EntityRepository
{
    public function findPublishedByCategoryQuery(Category $category): Query
    {
        $qb = $this->createQueryBuilder('a');

        return $qb
            ->where('a.category IN
                (SELECT c FROM Harentius\BlogBundle\Entity\Category c
                 WHERE c.left >= :left AND c.right <= :right AND c.root = :root)'
            )
            ->andWhere('a.published = :isPublished')
            ->setParameter(':left', $category->getLeft())
            ->setParameter(':right', $category->getRight())
            ->setParameter(':root', $category->getRoot())
            ->setParameter(':isPublished', true)
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
        ;
    }

    public function findPublishedByTagQuery(Tag $tag): Query
    {
        return $this->createQueryBuilder('a')
            ->join('a.tags', 't')
            ->where('t = :tag')
            ->andWhere('a.published = :isPublished')
            ->setParameter(':tag', $tag)
            ->setParameter(':isPublished', true)
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
        ;
    }

    /**
     * @param string $year
     * @param string $month
     */
    public function findPublishedByYearMonthQuery($year, $month = null): Query
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('YEAR(a.publishedAt) = :year')
            ->andWhere('a.published = :isPublished')
            ->setParameter(':year', $year)
            ->setParameter(':isPublished', true)
            ->orderBy('a.publishedAt', 'DESC')
        ;

        if ($month) {
            $qb
                ->andWhere('MONTH(a.publishedAt) = :month')
                ->setParameter(':month', $month)
            ;
        }

        return $qb->getQuery();
    }

    public function findPublishedByCategorySlugQueryBuilder(?string $categorySlug = null): QueryBuilder
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('a.published = :isPublished')
            ->setParameter(':isPublished', true)
            ->orderBy('a.publishedAt', 'DESC')
            ->addOrderBy('a.id', 'DESC')
        ;

        if ($categorySlug) {
            $qb
                ->join('a.category', 'c')
                ->andWhere('c.slug = :slug')
                ->setParameter(':slug', $categorySlug)
            ;
        }

        return $qb;
    }

    public function findLatestPublishedByCategorySlug(?string $categorySlug = null): ?Article
    {
        return $this
            ->findPublishedByCategorySlugQueryBuilder($categorySlug)
            ->orderBy('a.updatedAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return Article[]
     */
    public function findPublishedOrderedByPublishDate()
    {
        return $this->createQueryBuilder('a')
            ->where('a.published = :isPublished')
            ->setParameter(':isPublished', true)
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->execute()
        ;
    }
}
