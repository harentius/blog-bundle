<?php

namespace Harentius\BlogBundle\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

trait PageChangeableFieldsEntityTrait
{
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
