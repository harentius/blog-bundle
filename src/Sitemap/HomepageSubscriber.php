<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Sitemap;

use Harentius\BlogBundle\Homepage;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class HomepageSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly UrlGeneratorInterface $urlGenerator, private readonly Homepage $homepage)
    {
    }

    public function populate(SitemapPopulateEvent $event): void
    {
        $event->getUrlContainer()->addUrl(
            new UrlConcrete(
                $this->urlGenerator->generate('harentius_blog_homepage', [], UrlGeneratorInterface::ABSOLUTE_URL),
                $this->homepage->getUpdatedAt(),
                UrlConcrete::CHANGEFREQ_WEEKLY,
                1.0
            ),
            'pages'
        );
    }

    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::class => 'populate',
        ];
    }
}
