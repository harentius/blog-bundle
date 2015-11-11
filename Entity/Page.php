<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Harentius\BlogBundle\Entity\Base\AbstractPost;
use Harentius\BlogBundle\Entity\Base\PageChangeableFieldsEntityTrait;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatable;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\PageRepository")
 * @Gedmo\TranslationEntity(class="Harentius\BlogBundle\Entity\AbstractPostTranslation")
 */
class Page extends AbstractPost
{
    use PageChangeableFieldsEntityTrait;
    use PersonalTranslatable;


    /**
     *
     */
    public function __construct()
    {
        $this->isPublished = false;
    }
}
