<?php

namespace Harentius\BlogBundle\Twig;

use Harentius\BlogBundle\Router\PublicationUrlGenerator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

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
            new TwigFunction('publication_path', [$this->urlGenerator, 'generateUrl']),
        ];
    }
}
