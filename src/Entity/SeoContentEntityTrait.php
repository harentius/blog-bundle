<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

trait SeoContentEntityTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @SymfonyConstraints\Type(type="string")
     * @SymfonyConstraints\Length(max=255)
     */
    protected $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1000, nullable=true)
     * @SymfonyConstraints\Type(type="string")
     * @SymfonyConstraints\Length(max=1000)
     */
    protected $metaKeywords;

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setMetaDescription($value)
    {
        $this->metaDescription = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setMetaKeywords($value)
    {
        $this->metaKeywords = $value;

        return $this;
    }
}
