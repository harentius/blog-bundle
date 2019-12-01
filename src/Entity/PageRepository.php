<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PageRepository extends EntityRepository
{
    /**
     * @param $slug
     * @return Page[]
     */
    public function findPublishedNotSlugOrdered($slug)
    {
        return $this->createQueryBuilder('p')
            ->where('p.published = :isPublished')
            ->andWhere('p.slug <> :slug')
            ->setParameters([
                ':isPublished' => true,
                ':slug' => $slug,
            ])
            ->orderBy('p.order', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }
}
