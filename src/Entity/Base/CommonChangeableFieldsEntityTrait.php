<?php

namespace Harentius\BlogBundle\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Harentius\BlogBundle\Entity\AdminUser;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

trait CommonChangeableFieldsEntityTrait
{
    use TimestampableEntityTrait;
    use SeoContentEntityTrait;




}
