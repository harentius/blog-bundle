<?php

namespace Harentius\BlogBundle\Entity;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class CategoryRepository extends NestedTreeRepository
{
    /**
     * @param array $options
     * @return Category[]
     */
    public function notEmptyChildrenHierarchy(array $options = [])
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c.slug, c.name, c.level', 'c.id')
            ->addSelect('COUNT(a) AS articles_number')
                ->from('HarentiusBlogBundle:Article', 'a')
                ->where('a.category IN
                    (SELECT cc FROM HarentiusBlogBundle:Category cc
                     WHERE cc.left >= c.left AND cc.right <= c.right AND cc.root = c.root)'
                )
                ->andWhere('a.isPublished = :isPublished')
            ->setParameter('isPublished', true)
            ->orderBy('c.root, c.left', 'ASC')
            ->groupBy('c')
            ->getQuery()
        ;

        return $this->buildTree($qb->getArrayResult(), $options);
    }

    /**
     * @return Category[]
     */
    public function findWithPublishedArticles()
    {
        return $this->createQueryBuilder('c')
            ->from('HarentiusBlogBundle:Article', 'a')
            ->where('a.category IN
                    (SELECT cc FROM HarentiusBlogBundle:Category cc
                     WHERE cc.left >= c.left AND cc.right <= c.right AND cc.root = c.root)'
            )
            ->andWhere('a.isPublished = :isPublished')
            ->setParameter('isPublished', true)
            ->groupBy('c')
            ->getQuery()
            ->execute()
        ;
    }
}
