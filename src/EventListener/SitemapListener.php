<?php

namespace Harentius\BlogBundle\EventListener;

use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Entity\CategoryRepository;
use Harentius\BlogBundle\Entity\PageRepository;
use Harentius\BlogBundle\Homepage;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\Routing\RouterInterface;

class SitemapListener implements SitemapListenerInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var Homepage
     */
    private $homepage;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var string
     */
    private $homepageSlug;

    /**
     * @param RouterInterface $router
     * @param Homepage $homepage
     * @param ArticleRepository $articleRepository
     * @param PageRepository $pageRepository
     * @param CategoryRepository $categoryRepository
     * @param string $homepageSlug
     */
    public function __construct(
        RouterInterface $router,
        Homepage $homepage,
        ArticleRepository $articleRepository,
        PageRepository $pageRepository,
        CategoryRepository $categoryRepository,
        $homepageSlug
    ) {
        $this->router = $router;
        $this->homepage = $homepage;
        $this->articleRepository = $articleRepository;
        $this->pageRepository = $pageRepository;
        $this->categoryRepository = $categoryRepository;
        $this->homepageSlug = $homepageSlug;
    }

    /**
     * {@inheritdoc}
     */
    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $event->getGenerator()->addUrl(
            new UrlConcrete(
                $this->router->generate('harentius_blog_homepage', [], true),
                $this->homepage->getUpdatedAt(),
                UrlConcrete::CHANGEFREQ_WEEKLY,
                1.0
            ),
            'pages'
        );

        // Pages
        $pages = $this->pageRepository->findPublishedNotSlugOrdered($this->homepageSlug);

        foreach ($pages as $page) {
            $event->getGenerator()->addUrl(
                new UrlConcrete(
                    $this->router->generate('harentius_blog_show', ['slug' => $page->getSlug()], true),
                    $page->getUpdatedAt(),
                    UrlConcrete::CHANGEFREQ_MONTHLY,
                    0.5
                ),
                'pages'
            );
        }

        // Articles
        /** @var Article[] $articles */
        $articles = $this->articleRepository->findBy(['published' => true], ['publishedAt' => 'DESC']);

        foreach ($articles as $article) {
            $event->getGenerator()->addUrl(
                new UrlConcrete(
                    $this->router->generate('harentius_blog_show', ['slug' => $article->getSlug()], true),
                    $article->getUpdatedAt(),
                    UrlConcrete::CHANGEFREQ_MONTHLY,
                    0.9
                ),
                'articles'
            );
        }

        // Categories
        $addCategoriesRoutes = function ($categories) use ($event, &$addCategoriesRoutes) {
            foreach ($categories as $category) {
                $event->getGenerator()->addUrl(
                    new UrlConcrete(
                        $this->router->generate("harentius_blog_category_{$category['id']}", [], true),
                        null,
                        UrlConcrete::CHANGEFREQ_MONTHLY,
                        0.8
                    ),
                    'categories'
                );
                $addCategoriesRoutes($category['__children']);
            }
        };

        $addCategoriesRoutes($this->categoryRepository->notEmptyChildrenHierarchy());
    }
}
