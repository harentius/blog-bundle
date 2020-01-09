<?php

namespace Harentius\BlogBundle\Router;

use Harentius\BlogBundle\Entity\AbstractPost;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PublicationUrlGenerator
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var string
     */
    private $primaryLocale;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param string $primaryLocale
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, string $primaryLocale)
    {
        $this->urlGenerator = $urlGenerator;
        $this->primaryLocale = $primaryLocale;
    }

    /**
     * @param AbstractPost $post
     * @param string $locale
     * @param int $referenceType
     * @return string
     */
    public function generateUrl(
        AbstractPost $post,
        string $locale,
        int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH
    ): string {
        if ($locale === $this->primaryLocale) {
            return $this->urlGenerator->generate('harentius_blog_show_default', [
                'slug' => $post->getSlug(),
            ], $referenceType);
        }

        return $this->urlGenerator->generate('harentius_blog_show', [
            'slug' => $post->getSlug(),
            '_locale' => $locale,
        ], $referenceType);
    }
}
