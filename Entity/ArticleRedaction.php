<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Harentius\BlogBundle\Entity\Base\AbstractPostRedaction;
use Harentius\BlogBundle\Entity\Base\ArticleChangeableFieldsEntityTrait;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\ArticleRedactionRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({
 *      0 = "Harentius\BlogBundle\Entity\ArticleRedaction",
 *      1 = "Harentius\BlogBundle\Entity\PageRedaction",
 * })
 */
class ArticleRedaction extends AbstractPostRedaction
{
    use ArticleChangeableFieldsEntityTrait;

    /**
     * @var Article
     *
     * @ORM\OneToOne(targetEntity="Harentius\BlogBundle\Entity\Article")
     */
    private $article;

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param Article $value
     * @return $this
     */
    public function setArticle($value)
    {
        $this->article = $value;

        return $this;
    }
}
