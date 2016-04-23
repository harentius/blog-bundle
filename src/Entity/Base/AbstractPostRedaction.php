<?php

namespace Harentius\BlogBundle\Entity\Base;

use Symfony\Component\Validator\Constraints as SymfonyConstraints;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({
 *      0 = "Harentius\BlogBundle\Entity\ArticleRedaction",
 *      1 = "Harentius\BlogBundle\Entity\PageRedaction",
 * })
 */
abstract class AbstractPostRedaction
{
    use IdentifiableEntityTrait;
}
