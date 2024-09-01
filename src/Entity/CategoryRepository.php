<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Query;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[] findAll()
 * @method Category[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends NestedTreeRepository
{
    /**
     * @param array $options
     * @return Category[]
     */
    public function notEmptyChildrenHierarchy(array $options = [])
    {
        /** @var Query $q1 */
        $q1 = $this->createQueryBuilder('cc')
            ->where('cc.left >= c.left')
            ->andWhere('cc.right <= c.right')
            ->andWhere('cc.root = c.root')
            ->getQuery()
        ;

        /** @var ArticleRepository $articleRepository */
        $articleRepository = $this->getEntityManager()->getRepository(Article::class);
        $qb = $articleRepository->createQueryBuilder('a');
        $qb
            ->select('COUNT(a)')
            ->where($qb->expr()->in('a.category', $q1->getDQL()))
            ->andWhere('a.published = :isPublished')
        ;

        $q2 = $this->createQueryBuilder('c')
            ->addSelect('c.level')
            ->addSelect('(' . $qb->getDQL() . ') AS articles_number')
            ->orderBy('c.root, c.left', 'ASC')
            ->groupBy('c')
            ->having('articles_number > 0')
            ->setParameter(':isPublished', true)
            ->getQuery()
        ;

        return $this->buildTree($q2->getResult(), $options);
    }

    /**
     * @return Category[]
     */
    public function findWithPublishedArticles()
    {
        return $this->createQueryBuilder('c')
            ->from(Article::class, 'a')
            ->where('a.category IN
                    (SELECT cc FROM Harentius\BlogBundle\Entity\Category cc
                     WHERE cc.left >= c.left AND cc.right <= c.right AND cc.root = c.root)'
            )
            ->andWhere('a.published = :isPublished')
            ->setParameter('isPublished', true)
            ->groupBy('c')
            ->getQuery()
            ->execute()
        ;
    }
}
