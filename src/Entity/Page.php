<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Harentius\BlogBundle\Entity\Base\AbstractPost;
use Harentius\BlogBundle\Entity\Base\PageChangeableFieldsEntityTrait;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;

/**
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\PageRepository")
 * @Gedmo\TranslationEntity(class="Harentius\BlogBundle\Entity\Translation")
 */
class Page extends AbstractPost
{
    use PageChangeableFieldsEntityTrait;
    use PersonalTranslatableTrait;

    /**
     *
     */
    public function __construct()
    {
        $this->published = false;
    }
}
