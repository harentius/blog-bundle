<?php

namespace Harentius\BlogBundle\Entity\Base;

use Harentius\BlogBundle\Entity\AdminUser;
use Gedmo\Mapping\Annotation as Gedmo;

trait CommonChangeableFieldsEntityTrait
{
    use TimestampableEntityTrait;
    use SeoContentEntityTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1000)
     * @Gedmo\Translatable()
     * @SymfonyConstraints\Type(type="string")
     * @SymfonyConstraints\Length(max=1000)
     * @SymfonyConstraints\NotBlank()
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1000)
     * @Gedmo\Slug(fields={"title"}, unique=true, updatable=false)
     * @SymfonyConstraints\Type(type="string")
     * @SymfonyConstraints\Length(max=1000)
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
     *      targetEntity="Harentius\BlogBundle\Entity\AdminUser"
     * )
     * @SymfonyConstraints\NotNull()
     */
    protected $author;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean"))
     */
    protected $isPublished;

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
        return $this->title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setTitle($value)
    {
        $this->title = $value;

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
     * @return boolean
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param boolean $value
     * @return $this
     */
    public function setIsPublished($value)
    {
        $this->isPublished = $value;

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
