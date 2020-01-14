<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Controller;

use Harentius\BlogBundle\Controller\HomepageController;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Entity\PageRepository;
use Harentius\BlogBundle\Homepage;
use Harentius\BlogBundle\Paginator;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomepageControllerTest extends TestCase
{
    public function testInvoke(): void
    {
        $slidingPagination = new SlidingPagination([]);
        $slidingPagination->setItemNumberPerPage(10);
        $slidingPagination->setCurrentPageNumber(1);
        /** @var Environment|MockObject $twig */
        $twig = $this->createMock(Environment::class);
        $twig
            ->expects($this->once())
            ->method('render')
            ->with('@HarentiusBlog/Blog/index.html.twig', [
                'page' => null,
                'articles' => $slidingPagination,
                'hasToPaginate' => false,
                'noIndex' => false,
            ])
        ;
        $homepageController = $this->createHomepageController($twig, $slidingPagination);

        $request = new Request();
        $response = $homepageController($request);

        $this->assertInstanceOf(Response::class, $response);
    }

    private function createHomepageController(Environment $twig, SlidingPagination $slidingPagination): HomepageController
    {
        $articleRepository = $this->createMock(ArticleRepository::class);
        $pageRepository = $this->createMock(PageRepository::class);
        $homepage = new Homepage($articleRepository, $pageRepository, 'category_slug', 'homepage_slug');
        $knpPaginator = $this->createMock(PaginatorInterface::class);
        $knpPaginator
            ->method('paginate')
            ->willReturn($slidingPagination)
        ;

        $paginator = new Paginator($knpPaginator, 123);

        $controller = new HomepageController($homepage, $paginator, 5);
        $container = new Container();
        $container->set('twig', $twig);
        $controller->setContainer($container);

        return $controller;
    }
}
