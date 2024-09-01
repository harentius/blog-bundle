<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

#[ORM\Entity(repositoryClass: \Harentius\BlogBundle\Entity\AbstractPostRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'integer')]
#[ORM\DiscriminatorMap([0 => 'Harentius\BlogBundle\Entity\Article', 1 => 'Harentius\BlogBundle\Entity\Page'])]
abstract class AbstractPost
{
    use IdentifiableEntityTrait;
    use TimestampableEntityTrait;
    use SeoContentEntityTrait;

    /**
     * @var string|null
     */
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 1000)]
    #[SymfonyConstraints\Length(max: 1000)]
    #[SymfonyConstraints\NotBlank]
    protected ?string $title = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 1000)]
    #[Gedmo\Slug(fields: ['title'], unique: true, updatable: false)]
    protected ?string $slug = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::TEXT)]
    #[SymfonyConstraints\Type(type: 'string')]
    #[SymfonyConstraints\NotBlank]
    protected ?string $text = null;

    /**
     * @var AdminUser|null
     */
    #[ORM\ManyToOne(targetEntity: \Harentius\BlogBundle\Entity\AdminUser::class)]
    #[SymfonyConstraints\NotNull]
    protected ?\Harentius\BlogBundle\Entity\AdminUser $author = null;

    /**
     * @var bool
     */
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::BOOLEAN)]
    protected ?bool $published = null;

    /**
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE, nullable: true)]
    #[SymfonyConstraints\DateTime]
    protected ?\DateTimeInterface $publishedAt = null;

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
}
