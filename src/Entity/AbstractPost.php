<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
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
abstract class AbstractPost
{
    use IdentifiableEntityTrait;
    use TimestampableEntityTrait;
    use SeoContentEntityTrait;

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
     * @var string
     *
     * @ORM\Column(type="text")
     * @Gedmo\Translatable()
     * @SymfonyConstraints\Type(type="string")
     * @SymfonyConstraints\NotBlank()
     */
    protected $text;

    /**
     * @var AdminUser
     *
     * @ORM\ManyToOne(
     *     targetEntity="Harentius\BlogBundle\Entity\AdminUser"
     * )
     * @SymfonyConstraints\NotNull()
     */
    protected $author;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean"))
     */
    protected $published;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @SymfonyConstraints\DateTime
     */
    protected $publishedAt;

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

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setText($value)
    {
        $this->text = $value;

        return $this;
    }

    /**
     * @return AdminUser
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param AdminUser $value
     * @return $this
     */
    public function setAuthor($value)
    {
        $this->author = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setPublished($value)
    {
        $this->published = $value;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param \DateTime $value
     * @return $this
     */
    public function setPublishedAt($value)
    {
        $this->publishedAt = $value;

        return $this;
    }
}
