<?php

namespace Harentius\BlogBundle\Twig;

use Doctrine\Common\Cache\CacheProvider;
use Harentius\BlogBundle\Rating;
use Harentius\BlogBundle\SettingsProvider;
use Symfony\Bridge\Twig\Extension\HttpKernelExtension;
use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;
use Harentius\BlogBundle\Entity\Article;

class BlogExtension extends HttpKernelExtension
{
    /**
     * @var CacheProvider
     */
    private $cache;

    /**
     * @var int
     */
    private $sidebarCacheLifeTime;

    /**
     * @var Rating
     */
    private $rating;

    /**
     * @var SettingsProvider
     */
    private $settingsProvider;

    /**
     * @param FragmentHandler $handler A FragmentHandler instance
     * @param CacheProvider $cache
     * @param Rating $rating
     * @param SettingsProvider $settingsProvider
     * @param int $sidebarCacheLifeTime
     */
    public function __construct(
        FragmentHandler $handler,
        CacheProvider $cache,
        Rating $rating,
        SettingsProvider $settingsProvider,
        $sidebarCacheLifeTime
    ) {
        parent::__construct($handler);
        $this->cache = $cache;
        $this->rating = $rating;
        $this->settingsProvider = $settingsProvider;
        $this->sidebarCacheLifeTime = $sidebarCacheLifeTime;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('render_cached', [$this, 'renderCached'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('get_setting', [$this, 'getSetting']),
            new \Twig_SimpleFunction('is_article_liked', [$this, 'isArticleLiked']),
            new \Twig_SimpleFunction('is_article_disliked', [$this, 'isArticleDisLiked']),
            new \Twig_SimpleFunction('is_article_rated', [$this, 'isArticleRated']),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('read_more', [$this, 'readMore'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param $controllerReference
     * @param array $options
     * @return string
     */
    public function renderCached(ControllerReference $controllerReference, $options = [])
    {
        $key = $controllerReference->controller;

        if ($controllerReference->attributes !== []) {
            $key .= json_encode($controllerReference->attributes);
        }

        if ($controllerReference->query !== []) {
            $key .= json_encode($controllerReference->query);
        }

        if ($this->cache->contains($key)) {
            return $this->cache->fetch($key);
        }

        $renderedContent = $this->renderFragment($controllerReference, $options);
        $this->cache->save($key, $renderedContent);

        return $renderedContent;
    }

    /**
     * @param $content
     * @param null $url
     * @return string
     */
    public function readMore($content, $url = null)
    {
        if (($length = strpos($content, '<!--more-->')) !== false) {
            $content = substr($content, 0, $length);
        }

        if ($url !== null) {
            $content .= '<a href="' . $url . '">[..]</a>';
        }

        return $content;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getSetting($key)
    {
        return $this->settingsProvider->get($key);
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function isArticleLiked(Article $article)
    {
        return $this->rating->isLiked($article);
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function isArticleDisLiked(Article $article)
    {
        return $this->rating->isDisLiked($article);
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function isArticleRated(Article $article)
    {
        return $this->rating->isRated($article);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'blog_extension';
    }
}
