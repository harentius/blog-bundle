<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PageRepository extends EntityRepository
{
    /**
     * @param $slug
     * @return Page[]
     */
    public function findForMainMenu($slug)
    {
        return $this->createQueryBuilder('p')
            ->where('p.published = :isPublished')
            ->andWhere('p.showInMainMenu = :showInMainMenu')
            ->andWhere('p.slug <> :slug')
            ->setParameters([
                ':isPublished' => true,
                ':showInMainMenu' => true,
                ':slug' => $slug,
            ])
            ->orderBy('p.order', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }
}
