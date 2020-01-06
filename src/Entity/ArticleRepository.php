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
    /**
     * @param Category $category
     * @return Query
     */
    public function findPublishedByCategoryQuery(Category $category)
    {
        $qb = $this->createQueryBuilder('a');

        return $qb
            ->where('a.category IN
                (SELECT c FROM HarentiusBlogBundle:Category c
                 WHERE c.left >= :left AND c.right <= :right AND c.root = :root)'
            )
            ->andWhere('a.published = :isPublished')
            ->setParameters([
                ':left' => $category->getLeft(),
                ':right' => $category->getRight(),
                ':root' => $category->getRoot(),
                ':isPublished' => true,
            ])
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
        ;
    }

    /**
     * @param Tag $tag
     * @return Query
     */
    public function findPublishedByTagQuery(Tag $tag)
    {
        return $this->createQueryBuilder('a')
            ->join('a.tags', 't')
            ->where('t = :tag')
            ->andWhere('a.published = :isPublished')
            ->setParameters([
                ':tag' => $tag,
                ':isPublished' => true,
            ])
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
        ;
    }

    /**
     * @param string $year
     * @param string $month
     * @return Query
     */
    public function findPublishedByYearMonthQuery($year, $month = null)
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('YEAR(a.publishedAt) = :year')
            ->andWhere('a.published = :isPublished')
            ->setParameters([
                ':year' => $year,
                ':isPublished' => true,
            ])
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

    /**
     * @param string|null $categorySlug
     * @return QueryBuilder
     */
    public function findPublishedByCategorySlugQueryBuilder(?string $categorySlug = null): QueryBuilder
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('a.published = :isPublished')
            ->setParameter(':isPublished', true)
            ->orderBy('a.publishedAt', 'DESC')
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

    /**
     * @param string|null $categorySlug
     * @return Article|null
     */
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
