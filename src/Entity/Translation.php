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
     * @var Article
     *
     * @ORM\ManyToOne(
     *     targetEntity="Harentius\BlogBundle\Entity\AbstractPost",
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
    public function __construct(string $locale, string $field, string $value)
    {
        $this->setLocale($locale);
        $this->setField($field);
        $this->setContent($value);
    }
}
