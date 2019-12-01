<?php

namespace Harentius\BlogBundle\Twig;

use Harentius\BlogBundle\Router\PublicationUrlGenerator;
use Twig\Extension\AbstractExtension;

class PublicationUrlGeneratorExtension extends AbstractExtension
{
    /**
     * @var PublicationUrlGenerator
     */
    private $urlGenerator;

    /**
     * @param PublicationUrlGenerator $urlGenerator
     */
    public function __construct(PublicationUrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('publication_path', [$this->urlGenerator, 'generateUrl']),
            new \Twig_SimpleFunction('publication_path_for_slug', [$this->urlGenerator, 'generateUrlForSlug']),
        ];
    }
}
