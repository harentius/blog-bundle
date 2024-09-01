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
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly CategoryRepository $categoryRepository,
    ) {
    }

    public function populate(SitemapPopulateEvent $event): void
    {
        $categories = $this->categoryRepository->findWithPublishedArticles();

        foreach ($categories as $category) {
            $event->getUrlContainer()->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        'harentius_blog_category',
                        ['slug' => $category->getSlugWithParents()],
                        UrlGeneratorInterface::ABSOLUTE_URL,
                    ),
                    null,
                    UrlConcrete::CHANGEFREQ_MONTHLY,
                    1.0
                ),
                'categories'
            );
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::class => 'populate',
        ];
    }
}
