<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Controller;

use Harentius\BlogBundle\Breadcrumbs\BreadCrumbsManager;
use Harentius\BlogBundle\Controller\TagController;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Entity\Tag;
use Harentius\BlogBundle\Entity\TagRepository;
use Harentius\BlogBundle\Paginator;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;
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
        $tagRepository = $this->createMock(TagRepository::class);
        $tagRepository->method('findOneBy')->willReturn($tag);
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
        $tagController = $this->createTagController($twig, $tagRepository, $slidingPagination);
        $request = new Request();

        $response = $tagController->__invoke($request, 'slug');

        $this->assertInstanceOf(Response::class, $response);
    }

    private function createTagController(
        Environment $twig,
        TagRepository $tagRepository,
        SlidingPagination $slidingPagination,
    ): TagController {
        $articleRepository = $this->createMock(ArticleRepository::class);
        $breadCrumbsManager = $this->createMock(BreadCrumbsManager::class);
        $knpPaginator = $this->createMock(PaginatorInterface::class);
        $knpPaginator
            ->method('paginate')
            ->willReturn($slidingPagination)
        ;

        $paginator = new Paginator($knpPaginator, 123);
        $controller = new TagController($articleRepository, $breadCrumbsManager, $tagRepository, $paginator, $twig);

        return $controller;
    }
}
