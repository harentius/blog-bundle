<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Query;
use Gedmo\Translatable\Query\TreeWalker\TranslationWalker;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

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

        $qb = $this->_em->getRepository('HarentiusBlogBundle:Article')
            ->createQueryBuilder('a')
        ;
        $qb
            ->select('COUNT(a)')
            ->where($qb->expr()->in('a.category', $q1->getDQL()))
            ->andWhere('a.published = :isPublished')
        ;

        $q2 = $this->createQueryBuilder('c')
            ->select('c.slug, c.name, c.level, c.id')
            ->addSelect('(' . $qb->getDQL() . ') AS articles_number')
            ->orderBy('c.root, c.left', 'ASC')
            ->groupBy('c')
            ->having('articles_number > 0')
            ->setParameter(':isPublished', true)
            ->getQuery()
            ->setHint(
                Query::HINT_CUSTOM_OUTPUT_WALKER,
                TranslationWalker::class
            )
        ;

        return $this->buildTree($q2->getArrayResult(), $options);
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
            ->andWhere('a.published = :isPublished')
            ->setParameter('isPublished', true)
            ->groupBy('c')
            ->getQuery()
            ->execute()
        ;
    }
}
