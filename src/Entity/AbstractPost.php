<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Harentius\BlogBundle\Entity\Base\IdentifiableEntityTrait;
use Harentius\BlogBundle\Entity\Base\PublicationInterface;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

/**
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\AbstractPostRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({
 *     0 = "Harentius\BlogBundle\Entity\Article",
 *     1 = "Harentius\BlogBundle\Entity\Page",
 * })
 */
abstract class AbstractPost implements PublicationInterface
{
    use IdentifiableEntityTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=1000)
     * @Gedmo\Translatable()
     * @SymfonyConstraints\Length(max=1000)
     * @SymfonyConstraints\NotBlank()
     */
    protected $title;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=1000)
     * @Gedmo\Slug(fields={"title"}, unique=true, updatable=false)
     */
    protected $slug;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->title;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function setTitle(?string $value): self
    {
        $this->title = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSlug(?string $value): self
    {
        $this->slug = $value;

        return $this;
    }
}
