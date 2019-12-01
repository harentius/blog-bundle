<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Table(indexes={
 *     @ORM\Index(name="article_translation_idx", columns={"locale", "object_class", "field", "foreign_key"})
 * })
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\TranslationRepository")
 */
class Translation extends AbstractTranslation
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
