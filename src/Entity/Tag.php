<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

/**
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\TagRepository")
 */
class Tag
{
    use IdentifiableEntityTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255)
     * @SymfonyConstraints\Length(max=255)
     * @SymfonyConstraints\NotBlank()
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"}, unique=true)
     * @SymfonyConstraints\Length(max=255)
     */
    private $slug;

    /**
     * @var Article[]
     *
     * @ORM\ManyToMany(
     *     targetEntity="Harentius\BlogBundle\Entity\Article",
     *     mappedBy="tags",
     * )
     */
    private $articles;

    /**
     *
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->name;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function setName(?string $value): self
    {
        $this->name = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $value
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
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article[]|ArrayCollection $value
     * @return $this
     */
    public function setArticles($value): self
    {
        $this->articles = $value;

        return $this;
    }
}
