<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * @method Setting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Setting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Setting[] findAll()
 * @method Setting[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingRepository extends EntityRepository
{
}
