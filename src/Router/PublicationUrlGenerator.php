<?php

namespace Harentius\BlogBundle\Router;

use Harentius\BlogBundle\Entity\AbstractPost;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PublicationUrlGenerator
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @param RequestStack $requestStack
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(RequestStack $requestStack, UrlGeneratorInterface $urlGenerator)
    {
        $this->requestStack = $requestStack;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param AbstractPost $post
     * @param int $referenceType
     * @return string
     */
    public function generateUrl(AbstractPost $post, $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->generateUrlForSlug($post->getSlug(), $referenceType);
    }

    /**
     * @param string $slug
     * @param int $referenceType
     * @return string
     */
    public function generateUrlForSlug($slug, $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        $request = $this->requestStack->getCurrentRequest();
        $locale = $request->getLocale();
        $defaultLocale = $request->getDefaultLocale();

        if ($locale === $defaultLocale) {
            return $this->urlGenerator->generate('harentius_blog_show_default', [
                'slug' => $slug,
            ], $referenceType);
        }

        return $this->urlGenerator->generate('harentius_blog_show', [
            'slug' => $slug,
            '_locale' => $locale,
        ], $referenceType);
    }
}
