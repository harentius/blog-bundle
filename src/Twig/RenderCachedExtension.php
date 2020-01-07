<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Twig;

use Doctrine\Common\Cache\CacheProvider;
use Symfony\Bridge\Twig\Extension\HttpKernelRuntime;
use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RenderCachedExtension extends AbstractExtension
{
    /**
     * @var HttpKernelRuntime
     */
    private $httpKernelRuntime;

    /**
     * @var CacheProvider
     */
    private $cache;

    /**
     * @var int|null
     */
    private $sidebarCacheLifeTime;

    /**
     * @param HttpKernelRuntime $httpKernelRuntime
     * @param CacheProvider $cache
     * @param int|null $sidebarCacheLifeTime
     */
    public function __construct(
        HttpKernelRuntime $httpKernelRuntime,
        CacheProvider $cache,
        ?int $sidebarCacheLifeTime = null
    ) {
        $this->httpKernelRuntime = $httpKernelRuntime;
        $this->cache = $cache;
        $this->sidebarCacheLifeTime = $sidebarCacheLifeTime;
    }


    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('render_cached', [$this, 'renderCached'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param ControllerReference $controllerReference
     * @param array $options
     * @return string
     */
    public function renderCached(ControllerReference $controllerReference, array $options = []): string
    {
        $key = $controllerReference->controller;

        if ($controllerReference->attributes !== []) {
            $key .= json_encode($controllerReference->attributes);
        }

        if ($controllerReference->query !== []) {
            $key .= json_encode($controllerReference->query);
        }

        if ($this->cache->contains($key)) {
            return (string) $this->cache->fetch($key);
        }

        $renderedContent = $this->httpKernelRuntime->renderFragment($controllerReference, $options);
        $this->cache->save($key, $renderedContent, $this->sidebarCacheLifeTime);

        return $renderedContent;
    }
}
