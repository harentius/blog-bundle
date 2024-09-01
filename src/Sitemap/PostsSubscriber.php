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
    /**
     * @var AbstractPostRepository
     */
    private $abstractPostRepository;

    /**
     * @var PublicationUrlGenerator
     */
    private $publicationUrlGenerator;

    /**
     * @var string
     */
    private $primaryLocale;

    /**
     * @param AbstractPostRepository $abstractPostRepository
     * @param PublicationUrlGenerator $publicationUrlGenerator
     * @param string $primaryLocale
     */
    public function __construct(
        AbstractPostRepository $abstractPostRepository,
        PublicationUrlGenerator $publicationUrlGenerator,
        string $primaryLocale,
    ) {
        $this->abstractPostRepository = $abstractPostRepository;
        $this->publicationUrlGenerator = $publicationUrlGenerator;
        $this->primaryLocale = $primaryLocale;
    }

    /**
     * {@inheritdoc}
     */
    public function populate(SitemapPopulateEvent $event)
    {
        $posts = $this->abstractPostRepository->findPublished();

        foreach ($posts as $post) {
            $this->addUrl($event, $post, $this->primaryLocale);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            //   SitemapPopulateEvent::ON_SITEMAP_POPULATE => 'populate',
        ];
    }

    /**
     * @param SitemapPopulateEvent $event
     * @param AbstractPost $post
     * @param string $locale
     */
    private function addUrl(SitemapPopulateEvent $event, AbstractPost $post, string $locale): void
    {
        $event->getGenerator()->addUrl(
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
