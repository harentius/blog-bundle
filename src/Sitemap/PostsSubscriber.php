<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Sitemap;

use Harentius\BlogBundle\Entity\AbstractPost;
use Harentius\BlogBundle\Entity\AbstractPostRepository;
use Harentius\BlogBundle\Router\PublicationUrlGenerator;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PostsSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly AbstractPostRepository $abstractPostRepository,
        private readonly PublicationUrlGenerator $publicationUrlGenerator,
        private readonly string $primaryLocale
    ) {
    }

    public function populate(SitemapPopulateEvent $event): void
    {
        $posts = $this->abstractPostRepository->findPublished();

        foreach ($posts as $post) {
            $this->addUrl($event, $post, $this->primaryLocale);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::class => 'populate',
        ];
    }

    private function addUrl(SitemapPopulateEvent $event, AbstractPost $post, string $locale): void
    {
        $event->getUrlContainer()->addUrl(
            new UrlConcrete(
                $this->publicationUrlGenerator->generateUrl($post, $locale, UrlGeneratorInterface::ABSOLUTE_URL),
                $post->getUpdatedAt(),
                UrlConcrete::CHANGEFREQ_MONTHLY,
                0.5
            ),
            'pages'
        );
    }
}
