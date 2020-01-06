<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Sitemap;

use Harentius\BlogBundle\Entity\CategoryRepository;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CategoriesSubscriber implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, CategoryRepository $categoryRepository)
    {
        $this->urlGenerator = $urlGenerator;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function populate(SitemapPopulateEvent $event)
    {
        $categories = $this->categoryRepository->findWithPublishedArticles();

        foreach ($categories as $category) {
            $event->getGenerator()->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate('harentius_blog_category', ['slug' => $category->getSlugWithParents()]),
                    null,
                    UrlConcrete::CHANGEFREQ_MONTHLY,
                    1.0
                ),
                'categories'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::ON_SITEMAP_POPULATE => 'populate',
        ];
    }
}
