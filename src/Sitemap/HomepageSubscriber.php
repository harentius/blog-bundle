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
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var Homepage
     */
    private $homepage;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param Homepage $homepage
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, Homepage $homepage)
    {
        $this->urlGenerator = $urlGenerator;
        $this->homepage = $homepage;
    }

    /**
     * {@inheritdoc}
     */
    public function populate(SitemapPopulateEvent $event): void
    {
        $event->getGenerator()->addUrl(
            new UrlConcrete(
                $this->urlGenerator->generate('harentius_blog_homepage', [], true),
                $this->homepage->getUpdatedAt(),
                UrlConcrete::CHANGEFREQ_WEEKLY,
                1.0
            ),
            'pages'
        );
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
