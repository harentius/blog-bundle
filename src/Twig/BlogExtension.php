<?php

namespace Harentius\BlogBundle\Twig;

use Doctrine\Common\Cache\CacheProvider;
use Harentius\BlogBundle\Entity\AbstractPost;
use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Entity\TranslationRepository;
use Harentius\BlogBundle\Rating;
use Harentius\BlogBundle\SettingsProvider;
use Symfony\Bridge\Twig\Extension\HttpKernelRuntime;
use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class BlogExtension extends AbstractExtension
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
     * @var TranslationRepository
     */
    private $translationRepository;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var HttpKernelRuntime
     */
    private $httpKernelRuntime;

    /**
     * @param HttpKernelRuntime $httpKernelRuntime
     * @param CacheProvider $cache
     * @param Rating $rating
     * @param SettingsProvider $settingsProvider
     * @param int $sidebarCacheLifeTime
     * @param TranslationRepository $translationRepository
     * @param string $locale
     */
    public function __construct(
        HttpKernelRuntime $httpKernelRuntime,
        CacheProvider $cache,
        Rating $rating,
        SettingsProvider $settingsProvider,
        $sidebarCacheLifeTime,
        TranslationRepository $translationRepository,
        $locale
    ) {
        $this->cache = $cache;
        $this->rating = $rating;
        $this->settingsProvider = $settingsProvider;
        $this->sidebarCacheLifeTime = $sidebarCacheLifeTime;
        $this->translationRepository = $translationRepository;
        $this->locale = $locale;
        $this->httpKernelRuntime = $httpKernelRuntime;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('render_cached', [$this, 'renderCached'], ['is_safe' => ['html']]),
            new TwigFunction('get_setting', [$this, 'getSetting']),
            new TwigFunction('is_article_liked', [$this, 'isArticleLiked']),
            new TwigFunction('is_article_disliked', [$this, 'isArticleDisLiked']),
            new TwigFunction('is_article_rated', [$this, 'isArticleRated']),
            new TwigFunction('translations_list', [$this, 'translationsList']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new TwigFilter('read_more', [$this, 'readMore'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param ControllerReference $controllerReference
     * @param array $options
     * @return string
     */
    public function renderCached(ControllerReference $controllerReference, array $options = [])
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

        $renderedContent = $this->httpKernelRuntime->renderFragment($controllerReference, $options);
        $this->cache->save($key, $renderedContent, $this->sidebarCacheLifeTime);

        return $renderedContent;
    }

    /**
     * @param string $content
     * @param string|null $url
     * @return string
     */
    public function readMore(string $content, ?string $url = null)
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
     * @param AbstractPost $article
     * @return array
     */
    public function translationsList(AbstractPost $article)
    {
        return array_merge(
            [$this->locale],
            array_keys($this->translationRepository->findTranslations($article))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'blog_extension';
    }
}
