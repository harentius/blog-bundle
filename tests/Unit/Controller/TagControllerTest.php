<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Controller;

use Harentius\BlogBundle\Breadcrumbs\BreadCrumbsManager;
use Harentius\BlogBundle\Controller\TagController;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Entity\Tag;
use Harentius\BlogBundle\Paginator;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class TagControllerTest extends TestCase
{
    public function testInvoke(): void
    {
        $slidingPagination = new SlidingPagination([]);
        $slidingPagination->setItemNumberPerPage(10);
        $tag = new Tag();
        $twig = $this->createMock(Environment::class);
        $twig
            ->expects($this->once())
            ->method('render')
            ->with('@HarentiusBlog/Blog/list.html.twig', [
                'articles' => $slidingPagination,
                'parent' => $tag,
                'noIndex' => true,
                'hasToPaginate' => false,
            ])
        ;
        $tagController = $this->createTagController($twig, $slidingPagination);
        $request = new Request();

        $response = $tagController($request, $tag);

        $this->assertInstanceOf(Response::class, $response);
    }

    private function createTagController(Environment $twig, SlidingPagination $slidingPagination): TagController
    {
        $articleRepository = $this->createMock(ArticleRepository::class);
        $breadCrumbsManager = $this->createMock(BreadCrumbsManager::class);
        $knpPaginator = $this->createMock(PaginatorInterface::class);
        $knpPaginator
            ->method('paginate')
            ->willReturn($slidingPagination)
        ;

        $paginator = new Paginator($knpPaginator, 123);
        $controller = new TagController($articleRepository, $breadCrumbsManager, $paginator);
        $container = new Container();
        $container->set('twig', $twig);
        $controller->setContainer($container);

        return $controller;
    }
}
