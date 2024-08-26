<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Tree\Traits\NestedSetEntity;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\CategoryRepository")
 */
class Category
{
    use IdentifiableEntityTrait;
    use NestedSetEntity;
    use SeoContentEntityTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255)
     * @SymfonyConstraints\Type(type="string")
     * @SymfonyConstraints\Length(max=255)
     * @SymfonyConstraints\NotBlank()
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"}, unique=true)
     * @SymfonyConstraints\Type(type="string")
     * @SymfonyConstraints\Length(max=255)
     */
    private $slug;

    /**
     * @var Article[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Harentius\BlogBundle\Entity\Article",
     *     mappedBy="category",
     *     cascade={"remove"},
     * )
     */
    private $articles;

    /**
     * @var Category|null
     *
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(
     *     targetEntity="Harentius\BlogBundle\Entity\Category",
     *     inversedBy="children"
     * )
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @var Category[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Harentius\BlogBundle\Entity\Category",
     *     mappedBy="parent"
     * )
     * @ORM\OrderBy({"left" = "ASC"})
     */
    private $children;

    /**
     *
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->children = new ArrayCollection();
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

    /**
     * @return Category|null
     */
    public function getParent(): ?Category
    {
        return $this->parent;
    }

    /**
     * @param Category|null $value
     * @return $this
     */
    public function setParent(?Category $value): self
    {
        $this->parent = $value;

        return $this;
    }

    /**
     * @return Category[]|ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Category[] $value
     * @return $this
     */
    public function setChildren($value): self
    {
        $this->children = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getLeft(): ?int
    {
        return $this->left;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setLeft(?int $value): self
    {
        $this->left = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getRight(): ?int
    {
        return $this->right;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setRight(?int $value): self
    {
        $this->right = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getRoot(): ?int
    {
        return $this->root;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setRoot(?int $value): self
    {
        $this->root = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlugWithParents(): string
    {
        $slugs = [];
        $category = $this;

        do {
            array_unshift($slugs, $category->getSlug());
        } while ($category = $category->getParent());

        return implode('/', $slugs);
    }
}
