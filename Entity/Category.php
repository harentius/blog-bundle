<?php

namespace Harentius\BlogBundle\Entity;

use Harentius\BlogBundle\Entity\Base\IdentifiableEntityTrait;
use Harentius\BlogBundle\Entity\Base\SeoContentEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Tree\Traits\NestedSetEntity;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;
use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @SymfonyConstraints\Type(type="string")
     * @SymfonyConstraints\Length(max=255)
     * @SymfonyConstraints\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"}, unique=true)
     * @SymfonyConstraints\Type(type="string")
     * @SymfonyConstraints\Length(max=255)
     */
    private $slug;

    /**
     * @var Article[]
     *
     * @ORM\OneToMany(
     *      targetEntity="Harentius\BlogBundle\Entity\Article",
     *      mappedBy="category",
     *      cascade={"remove"},
     * )
     */
    private $articles;

    /**
     * @var Tag
     *
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(
     *      targetEntity="Harentius\BlogBundle\Entity\Category",
     *      inversedBy="children"
     * )
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @var Tag[]
     *
     * @ORM\OneToMany(
     *      targetEntity="Harentius\BlogBundle\Entity\Category",
     *      mappedBy="parent"
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
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setName($value)
    {
        $this->name = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSlug($value)
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
     * @param Article[] $value
     * @return $this
     */
    public function setArticles($value)
    {
        $this->articles = $value;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setParent($value)
    {
        $this->parent = $value;

        return $this;
    }

    /**
     * @return Tag[]|ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Tag[] $value
     * @return $this
     */
    public function setChildren($value)
    {
        $this->children = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setLeft($value)
    {
        $this->left = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setRight($value)
    {
        $this->right = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setRoot($value)
    {
        $this->root = $value;

        return $this;
    }
}
