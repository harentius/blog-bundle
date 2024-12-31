<?php

namespace Harentius\BlogBundle\Router;

use Harentius\BlogBundle\Entity\AbstractPost;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PublicationUrlGenerator
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function generateUrl(
        AbstractPost $post,
        string $locale,
        int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH,
    ): string {
        return $this->urlGenerator->generate('harentius_blog_show_default', [
            'slug' => $post->getSlug(),
        ], $referenceType);
    }
}
