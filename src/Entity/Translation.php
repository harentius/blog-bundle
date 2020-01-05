<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\TranslationRepository")
 */
class Translation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(
     *     targetEntity="Harentius\BlogBundle\Entity\Article",
     *     inversedBy="translations"
     * )
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $object;

    /**
     * @param string $locale
     * @param string $field
     * @param string $value
     */
    public function __construct($locale, $field, $value)
    {
        $this->setLocale($locale);
        $this->setField($field);
        $this->setContent($value);
    }
}
