<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * @method Translation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Translation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Translation[] findAll()
 * @method Translation[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslationRepository extends EntityRepository
{
    /**
     * @param object $object
     * @return string[]
     */
    public function findTranslations($object)
    {
        $result = $this->createQueryBuilder('t')
            ->select('t.locale')
            ->distinct()
            ->where('t.object = :object')
            ->setParameter('object', $object)
            ->getQuery()
            ->getArrayResult()
        ;

        return array_column($result, 'locale');
    }
}
