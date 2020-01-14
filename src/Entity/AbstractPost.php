<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatableTrait;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

/**
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\AbstractPostRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({
 *     0 = "Harentius\BlogBundle\Entity\Article",
 *     1 = "Harentius\BlogBundle\Entity\Page",
 * })
 * @Gedmo\TranslationEntity(class="Harentius\BlogBundle\Entity\Translation")
 */
abstract class AbstractPost implements TranslatableInterface
{
    use IdentifiableEntityTrait;
    use TimestampableEntityTrait;
    use SeoContentEntityTrait;
    use PersonalTranslatableTrait;

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
     * @var string|null
     *
     * @ORM\Column(type="text")
     * @Gedmo\Translatable()
     * @SymfonyConstraints\Type(type="string")
     * @SymfonyConstraints\NotBlank()
     */
    protected $text;

    /**
     * @var AdminUser|null
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
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @SymfonyConstraints\DateTime
     */
    protected $publishedAt;

    /**
     * @var Translation[]
     *
     * @ORM\OneToMany(
     *     targetEntity="Harentius\BlogBundle\Entity\Translation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;

    /**
     *
     */
    public function __construct()
    {
        $this->published = false;
    }

    /**
     * @return string
     */
    public function __toString(): string
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
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function setText(?string $value): self
    {
        $this->text = $value;

        return $this;
    }

    /**
     * @return AdminUser|null
     */
    public function getAuthor(): ?AdminUser
    {
        return $this->author;
    }

    /**
     * @param AdminUser|null $value
     * @return $this
     */
    public function setAuthor(?AdminUser $value): self
    {
        $this->author = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setPublished(bool $value): self
    {
        $this->published = $value;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPublishedAt(): ?\DateTime
    {
        return $this->publishedAt;
    }

    /**
     * @param \DateTime|null $value
     * @return $this
     */
    public function setPublishedAt(?\DateTime $value): self
    {
        $this->publishedAt = $value;

        return $this;
    }

    /**
     * @return Translation[]
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param Translation[] $value
     * @return $this
     */
    public function setTranslations($value): self
    {
        $this->translations = $value;

        return $this;
    }
}
