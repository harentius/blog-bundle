<?php

namespace Harentius\BlogBundle\Router;

use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class RouteProvider implements RouteProviderInterface
{
    /**
     * @var RouteCollection
     */
    private $routes;

    /**
     * Container uses for avoiding crashes while rebuilding
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->routes = new RouteCollection();
        $this->container = $container;
    }

    /**
     * @inheritdoc
     */
    public function getRouteCollectionForRequest(Request $request)
    {
        $slugProvider = $this->container->get('harentius_blog.router.category_slug_provider');

        foreach ($slugProvider->getAll() as $categoryId => $fullSlug) {
            $this->routes->add("harentius_blog_category_{$categoryId}", new Route(
                "/category{$fullSlug}",
                ['_controller' => 'HarentiusBlogBundle:Blog:list', 'filtrationType' => 'category', 'criteria' => $categoryId]
            ));

        }

        return $this->routes;
    }

    /**
     * @inheritdoc
     */
    public function getRouteByName($name, $params = [])
    {
        if ($route = $this->routes->get($name)) {
            return $route;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getRoutesByNames($names)
    {
        return [];
    }
}
