<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Controller;

use Harentius\BlogBundle\BreadCrumbsManager;
use Harentius\BlogBundle\Controller\CategoryController;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Entity\Category;
use Harentius\BlogBundle\Entity\CategoryRepository;
use Harentius\BlogBundle\Paginator;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class CategoryControllerTest extends TestCase
{
    public function testInvoke(): void
    {
        $slidingPagination = new SlidingPagination([]);
        $slidingPagination->setItemNumberPerPage(10);
        $category = new Category();
        $twig = $this->createMock(Environment::class);
        $twig
            ->expects($this->once())
            ->method('render')
            ->with('@HarentiusBlog/Blog/list.html.twig', [
                'articles' => $slidingPagination,
                'parent' => $category,
                'hasToPaginate' => false,
            ])
        ;
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $categoryRepository
            ->method('findOneBy')
            ->willReturn($category)
        ;
        $archiveController = $this->createCategoryController($twig, $slidingPagination, $categoryRepository);

        $request = new Request();
        $response = $archiveController($request, 'category-slug');

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testInvokeResolveSlug(): void
    {
        $slidingPagination = new SlidingPagination([]);
        $slidingPagination->setItemNumberPerPage(10);
        $category = new Category();
        $category->setSlug('parent-slug/child-slug');
        $twig = $this->createMock(Environment::class);
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $categoryRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['slug' => 'child-slug'])
            ->willReturn($category)
        ;
        $archiveController = $this->createCategoryController($twig, $slidingPagination, $categoryRepository);
        $request = new Request();
        $archiveController($request, 'parent-slug/child-slug');
    }

    public function testInvokeNotFound(): void
    {
        $slidingPagination = new SlidingPagination([]);
        $slidingPagination->setItemNumberPerPage(10);
        $twig = $this->createMock(Environment::class);
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $archiveController = $this->createCategoryController($twig, $slidingPagination, $categoryRepository);
        $request = new Request();
        $this->expectException(NotFoundHttpException::class);
        $archiveController($request, 'parent-slug/child-slug');
    }

    private function createCategoryController(
        Environment $twig,
        SlidingPagination $slidingPagination,
        CategoryRepository $categoryRepository
    ): CategoryController {
        $articleRepository = $this->createMock(ArticleRepository::class);
        $breadCrumbsManager = $this->createMock(BreadCrumbsManager::class);
        $knpPaginator = $this->createMock(PaginatorInterface::class);
        $knpPaginator
            ->method('paginate')
            ->willReturn($slidingPagination)
        ;

        $paginator = new Paginator($knpPaginator, 123);

        $controller = new CategoryController($articleRepository, $categoryRepository, $breadCrumbsManager, $paginator);
        $container = new Container();
        $container->set('twig', $twig);
        $controller->setContainer($container);

        return $controller;
    }
}
