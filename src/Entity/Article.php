<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

/**
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\ArticleRepository")
 */
class Article extends AbstractPost
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @SymfonyConstraints\Type(type="integer")
     * @SymfonyConstraints\Range(min=0)
     * @SymfonyConstraints\NotNull()
     */
    protected $viewsCount;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @SymfonyConstraints\Type(type="integer")
     * @SymfonyConstraints\Range(min=0)
     * @SymfonyConstraints\NotNull()
     */
    protected $likesCount;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @SymfonyConstraints\Type(type="integer")
     * @SymfonyConstraints\Range(min=0)
     * @SymfonyConstraints\NotNull()
     */
    protected $disLikesCount;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=false)
     * @SymfonyConstraints\Type(type="array")
     * @SymfonyConstraints\NotNull()
     */
    protected $attributes;

    /**
     * @var Category|null
     *
     * @ORM\ManyToOne(
     *     targetEntity="Harentius\BlogBundle\Entity\Category",
     *     inversedBy="articles"
     * )
     * @SymfonyConstraints\NotNull()
     */
    private $category;

    /**
     * @var Tag[]
     *
     * @ORM\ManyToMany(
     *     targetEntity="Harentius\BlogBundle\Entity\Tag",
     *     inversedBy="articles"
     * )
     */
    private $tags;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->viewsCount = 0;
        $this->likesCount = 0;
        $this->disLikesCount = 0;
        $this->tags = new ArrayCollection();
        $this->attributes = [];
    }

    /**
     * @return int
     */
    public function getViewsCount(): int
    {
        return $this->viewsCount;
    }

    /**
     *
     */
    public function increaseViewsCount(): void
    {
        $this->viewsCount = $this->getViewsCount() + 1;
    }

    /**
     * @return int
     */
    public function getLikesCount(): int
    {
        return $this->likesCount;
    }

    /**
     *
     */
    public function increaseLikesCount(): void
    {
        $this->likesCount = $this->getLikesCount() + 1;
    }

    /**
     * @return int
     */
    public function getDisLikesCount(): int
    {
        return $this->disLikesCount;
    }

    /**
     *
     */
    public function increaseDisLikesCount(): void
    {
        $this->disLikesCount = $this->getDisLikesCount() + 1;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $value
     * @return $this
     */
    public function setAttributes(array $value): self
    {
        $this->attributes = $value;

        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $value
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
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag[]|ArrayCollection $value
     * @return $this
     */
    public function setTags($value): self
    {
        $this->tags = $value;

        return $this;
    }

    /**
     * @param Tag $value
     * @return $this
     */
    public function addTag(Tag $value): self
    {
        $this->tags[] = $value;

        return $this;
    }

    // RSS

    /**
     * {@inheritdoc}
     */
    public function getFeedItemTitle(): ?string
    {
        return $this->getTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function getFeedItemDescription(): ?string
    {
        return $this->getMetaDescription();
    }

    /**
     * {@inheritdoc}
     */
    public function getFeedItemLink(): ?string
    {
        return $this->getSlug();
    }

    /**
     * {@inheritdoc}
     */
    public function getFeedItemPubDate(): ?\DateTime
    {
        return $this->getPublishedAt();
    }
}
