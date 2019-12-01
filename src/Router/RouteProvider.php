<?php

namespace Harentius\BlogBundle\Router;

use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteProvider implements RouteProviderInterface
{
    /**
     * @var RouteCollection
     */
    protected $routes;

    /**
     * @var CategorySlugProvider
     */
    private $categorySlugProvider;

    /**
     * @param CategorySlugProvider $categorySlugProvider
     */
    public function __construct(CategorySlugProvider $categorySlugProvider)
    {
        $this->routes = new RouteCollection();
        $this->categorySlugProvider = $categorySlugProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteCollectionForRequest(Request $request)
    {
        foreach ($this->categorySlugProvider->getAll() as $categoryId => $fullSlug) {
            $this->routes->add("harentius_blog_category_{$categoryId}", new Route(
                "/category{$fullSlug}",
                ['_controller' => 'HarentiusBlogBundle:Blog:list', 'filtrationType' => 'category', 'criteria' => $categoryId]
            ));
        }

        return $this->routes;
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteByName($name, $params = [])
    {
        if ($route = $this->routes->get($name)) {
            return $route;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutesByNames($names)
    {
        return [];
    }
}
