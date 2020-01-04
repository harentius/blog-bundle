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
            ->setParameters([
                ':isPublished' => true,
                ':showInMainMenu' => true,
                ':slug' => $slug,
            ])
            ->orderBy('p.order', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
