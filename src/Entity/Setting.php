<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

#[ORM\Entity(repositoryClass: SettingRepository::class)]
class Setting
{
    use IdentifiableEntityTrait;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::TEXT, name: '_key')]
    #[SymfonyConstraints\Length(max: 255)]
    #[SymfonyConstraints\NotBlank]
    private ?string $key = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::TEXT)]
    #[SymfonyConstraints\Length(max: 255)]
    #[SymfonyConstraints\NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::TEXT)]
    private ?string $value = null;

    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @return $this
     */
    public function setKey(?string $value): self
    {
        $this->key = $value;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return $this
     */
    public function setName(?string $value): self
    {
        $this->name = $value;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @return $this
     */
    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
