<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Harentius\BlogBundle\Entity\Base\AbstractPostRedaction;
use Harentius\BlogBundle\Entity\Base\PageChangeableFieldsEntityTrait;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\ArticleRedactionRepository")
 */
class PageRedaction extends AbstractPostRedaction
{
    use PageChangeableFieldsEntityTrait;

    /**
     * @var Page
     *
     * @ORM\OneToOne(targetEntity="Harentius\BlogBundle\Entity\Page")
     */
    private $page;

    /**
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param Page $value
     * @return $this
     */
    public function setPage($value)
    {
        $this->page = $value;

        return $this;
    }
}
