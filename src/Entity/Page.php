<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Harentius\BlogBundle\Entity\Base\CommonChangeableFieldsEntityTrait;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

/**
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\PageRepository")
 * @Gedmo\TranslationEntity(class="Harentius\BlogBundle\Entity\Translation")
 */
class Page extends AbstractPost
{
    use PersonalTranslatableTrait;
    use CommonChangeableFieldsEntityTrait;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @SymfonyConstraints\NotNull()
     * @SymfonyConstraints\Type(type="bool")
     */
    private $showInMainMenu;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true, name="_order")
     * @SymfonyConstraints\Type(type="integer")
     */
    private $order;

    /**
     *
     */
    public function __construct()
    {
        $this->published = false;
    }

    /**
     * @return bool
     */
    public function getShowInMainMenu()
    {
        return $this->showInMainMenu;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setShowInMainMenu($value)
    {
        $this->showInMainMenu = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setOrder($value)
    {
        $this->order = $value;

        return $this;
    }
}
