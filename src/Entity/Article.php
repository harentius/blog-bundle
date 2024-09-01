<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article extends AbstractPost
{
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::INTEGER)]
    #[SymfonyConstraints\Type(type: 'integer')]
    #[SymfonyConstraints\Range(min: 0)]
    #[SymfonyConstraints\NotNull]
    protected ?int $viewsCount = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::INTEGER)]
    #[SymfonyConstraints\Type(type: 'integer')]
    #[SymfonyConstraints\Range(min: 0)]
    #[SymfonyConstraints\NotNull]
    protected ?int $likesCount = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::INTEGER)]
    #[SymfonyConstraints\Type(type: 'integer')]
    #[SymfonyConstraints\Range(min: 0)]
    #[SymfonyConstraints\NotNull]
    protected ?int $disLikesCount = null;

    /**
     * @var array
     */
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::ARRAY, nullable: false)]
    #[SymfonyConstraints\Type(type: 'array')]
    #[SymfonyConstraints\NotNull]
    protected $attributes;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'articles')]
    #[SymfonyConstraints\NotNull]
    private ?Category $category = null;

    /**
     * @var \Doctrine\Common\Collections\Collection<int, \Harentius\BlogBundle\Entity\Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'articles')]
    private \Doctrine\Common\Collections\Collection $tags;

    public function __construct()
    {
        parent::__construct();
        $this->viewsCount = 0;
        $this->likesCount = 0;
        $this->disLikesCount = 0;
        $this->tags = new ArrayCollection();
        $this->attributes = [];
    }

    public function getViewsCount(): int
    {
        return $this->viewsCount;
    }

    public function increaseViewsCount(): void
    {
        $this->viewsCount = $this->getViewsCount() + 1;
    }

    public function getLikesCount(): int
    {
        return $this->likesCount;
    }

    public function increaseLikesCount(): void
    {
        $this->likesCount = $this->getLikesCount() + 1;
    }

    public function getDisLikesCount(): int
    {
        return $this->disLikesCount;
    }

    public function increaseDisLikesCount(): void
    {
        $this->disLikesCount = $this->getDisLikesCount() + 1;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return $this
     */
    public function setAttributes(array $value): self
    {
        $this->attributes = $value;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @return $this
     */
    public function setCategory(?Category $value): self
    {
        $this->category = $value;

        return $this;
    }

    /**
     * @return Tag[]|ArrayCollection
     */
    public function getTags(): \Doctrine\Common\Collections\Collection
    {
        return $this->tags;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection<int, \Harentius\BlogBundle\Entity\Tag> $value
     * @return $this
     */
    public function setTags(\Doctrine\Common\Collections\Collection $value): self
    {
        $this->tags = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function addTag(Tag $value): self
    {
        $this->tags[] = $value;

        return $this;
    }

    // RSS

    public function getFeedItemTitle(): ?string
    {
        return $this->getTitle();
    }

    public function getFeedItemDescription(): ?string
    {
        return $this->getMetaDescription();
    }

    public function getFeedItemLink(): ?string
    {
        return $this->getSlug();
    }

    public function getFeedItemPubDate(): ?\DateTime
    {
        return $this->getPublishedAt();
    }
}
