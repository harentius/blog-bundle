<?php

namespace Harentius\BlogBundle\Entity\Base;

use Symfony\Component\Validator\Constraints as SymfonyConstraints;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({
 *      0 = "Harentius\BlogBundle\Entity\Article",
 *      1 = "Harentius\BlogBundle\Entity\Page",
 * })
 */
abstract class AbstractPost
{
    use IdentifiableEntityTrait;
}
