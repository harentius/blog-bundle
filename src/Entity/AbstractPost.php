<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

#[ORM\Entity(repositoryClass: AbstractPostRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'integer')]
#[ORM\DiscriminatorMap([0 => Article::class, 1 => Page::class])]
abstract class AbstractPost implements \Stringable
{
    use IdentifiableEntityTrait;
    use SeoContentEntityTrait;
    use TimestampableEntityTrait;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 1000)]
    #[SymfonyConstraints\Length(max: 1000)]
    #[SymfonyConstraints\NotBlank]
    protected ?string $title = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 1000)]
    #[Gedmo\Slug(fields: ['title'], unique: true, updatable: false)]
    protected ?string $slug = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::TEXT)]
    #[SymfonyConstraints\Type(type: 'string')]
    #[SymfonyConstraints\NotBlank]
    protected ?string $text = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::BOOLEAN)]
    protected ?bool $published = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE, nullable: true)]
    #[SymfonyConstraints\DateTime]
    protected ?\DateTimeInterface $publishedAt = null;

    public function __construct()
    {
        $this->published = false;
    }

    public function __toString(): string
    {
        return (string) $this->title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return $this
     */
    public function setTitle(?string $value): self
    {
        $this->title = $value;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return $this
     */
    public function setText(?string $value): self
    {
        $this->text = $value;

        return $this;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @return $this
     */
    public function setPublished(bool $value): self
    {
        $this->published = $value;

        return $this;
    }

    public function getPublishedAt(): ?\DateTime
    {
        return $this->publishedAt;
    }

    /**
     * @return $this
     */
    public function setPublishedAt(?\DateTime $value): self
    {
        $this->publishedAt = $value;

        return $this;
    }
}
