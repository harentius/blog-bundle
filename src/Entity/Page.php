<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

/**
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\PageRepository")
 */
class Page extends AbstractPost
{
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
        parent::__construct();
        $this->showInMainMenu = false;
        $this->order = 0;
    }

    /**
     * @return bool
     */
    public function getShowInMainMenu(): bool
    {
        return $this->showInMainMenu;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setShowInMainMenu(bool $value): self
    {
        $this->showInMainMenu = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setOrder(int $value): self
    {
        $this->order = $value;

        return $this;
    }
}
