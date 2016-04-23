<?php

namespace Harentius\BlogBundle\Entity;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(indexes={
 *      @ORM\Index(name="article_translation_idx", columns={"locale", "object_class", "field", "foreign_key"})
 * })
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\TranslationRepository")
 */
class Translation extends AbstractTranslation
{
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

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Harentius\BlogBundle\Entity\Article",
     *      inversedBy="translations"
     * )
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $object;
}
