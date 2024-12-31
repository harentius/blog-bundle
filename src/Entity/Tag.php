<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag implements \Stringable
{
    use IdentifiableEntityTrait;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    #[SymfonyConstraints\Length(max: 255)]
    #[SymfonyConstraints\NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    #[SymfonyConstraints\Length(max: 255)]
    #[Gedmo\Slug(fields: ['name'], unique: true)]
    private ?string $slug = null;

    /**
     * @var \Doctrine\Common\Collections\Collection<int, \Harentius\BlogBundle\Entity\Article>
     */
    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'tags')]
    private \Doctrine\Common\Collections\Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->name;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return $this
     */
    public function setSlug(?string $value): self
    {
        $this->slug = $value;

        return $this;
    }

    /**
     * @return Article[]|ArrayCollection
     */
    public function getArticles(): \Doctrine\Common\Collections\Collection
    {
        return $this->articles;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection<int, \Harentius\BlogBundle\Entity\Article> $value
     * @return $this
     */
    public function setArticles(\Doctrine\Common\Collections\Collection $value): self
    {
        $this->articles = $value;

        return $this;
    }
}
