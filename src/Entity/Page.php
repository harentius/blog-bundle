<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page extends AbstractPost
{
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::BOOLEAN)]
    #[SymfonyConstraints\NotNull]
    #[SymfonyConstraints\Type(type: 'bool')]
    private ?bool $showInMainMenu = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::INTEGER, nullable: true, name: '_order')]
    #[SymfonyConstraints\Type(type: 'integer')]
    private ?int $order = null;

    public function __construct()
    {
        parent::__construct();
        $this->showInMainMenu = false;
        $this->order = 0;
    }

    public function getShowInMainMenu(): bool
    {
        return $this->showInMainMenu;
    }

    /**
     * @return $this
     */
    public function setShowInMainMenu(bool $value): self
    {
        $this->showInMainMenu = $value;

        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @return $this
     */
    public function setOrder(int $value): self
    {
        $this->order = $value;

        return $this;
    }
}
