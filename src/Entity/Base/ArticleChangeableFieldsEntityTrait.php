<?php

namespace Harentius\BlogBundle\Entity\Base;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Harentius\BlogBundle\Entity\Category;
use Harentius\BlogBundle\Entity\Tag;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

trait ArticleChangeableFieldsEntityTrait
{
    use CommonChangeableFieldsEntityTrait;

    /**
     * @var Category
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
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $value
     * @return $this
     */
    public function setCategory($value)
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
     * @param Tag[] $value
     * @return $this
     */
    public function setTags($value)
    {
        $this->tags = $value;

        return $this;
    }

    /**
     * @param Tag $value
     * @return $this
     */
    public function addTag($value)
    {
        $this->tags[] = $value;

        return $this;
    }
}
