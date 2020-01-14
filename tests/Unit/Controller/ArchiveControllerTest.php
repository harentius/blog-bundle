<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Controller;

use Harentius\BlogBundle\BreadCrumbsManager;
use Harentius\BlogBundle\Controller\ArchiveController;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Paginator;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ArchiveControllerTest extends TestCase
{
    public function testInvoke(): void
    {
        $slidingPagination = new SlidingPagination([]);
        $slidingPagination->setItemNumberPerPage(10);
        $twig = $this->createMock(Environment::class);
        $twig
            ->expects($this->once())
            ->method('render')
            ->with('@HarentiusBlog/Blog/list.html.twig', [
                'articles' => $slidingPagination,
                'year' => '2018',
                'month' => 'June',
                'noIndex' => true,
                'hasToPaginate' => false,
            ])
        ;
        $archiveController = $this->createArchiveController($twig, $slidingPagination);

        $request = new Request();
        $request->setLocale('en');
        $response = $archiveController($request, '2018', '06');

        $this->assertInstanceOf(Response::class, $response);
    }

    private function createArchiveController(Environment $twig, SlidingPagination $slidingPagination): ArchiveController
    {
        $articleRepository = $this->createMock(ArticleRepository::class);
        $breadCrumbsManager = $this->createMock(BreadCrumbsManager::class);
        $knpPaginator = $this->createMock(PaginatorInterface::class);
        $knpPaginator
            ->method('paginate')
            ->willReturn($slidingPagination)
        ;

        $paginator = new Paginator($knpPaginator, 123);

        $controller = new ArchiveController($articleRepository, $breadCrumbsManager, $paginator);
        $container = new Container();
        $container->set('twig', $twig);
        $controller->setContainer($container);

        return $controller;
    }
}
