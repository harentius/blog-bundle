<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Controller;

use Harentius\BlogBundle\Breadcrumbs\BreadCrumbsManager;
use Harentius\BlogBundle\Controller\ShowController;
use Harentius\BlogBundle\Entity\AbstractPostRepository;
use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Entity\Page;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ShowControllerTest extends TestCase
{
    public function testInvokeWithArticle(): void
    {
        $article = new Article();
        $abstractPostRepository = $this->createMock(AbstractPostRepository::class);
        $abstractPostRepository->method('findOneBy')->willReturn($article);
        $twig = $this->createMock(Environment::class);
        $twig
            ->expects($this->once())
            ->method('render')
            ->with('@HarentiusBlog/Show/article.html.twig', [
                'entity' => $article,
            ])
        ;
        $showController = $this->createShowController($twig, $abstractPostRepository);
        $response = $showController->__invoke('slug');
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testInvokeWithPage(): void
    {
        $page = new Page();
        $abstractPostRepository = $this->createMock(AbstractPostRepository::class);
        $abstractPostRepository->method('findOneBy')->willReturn($page);
        $twig = $this->createMock(Environment::class);
        $twig
            ->expects($this->once())
            ->method('render')
            ->with('@HarentiusBlog/Show/page.html.twig', [
                'entity' => $page,
            ])
        ;
        $showController = $this->createShowController($twig, $abstractPostRepository);
        $response = $showController->__invoke('slug');
        $this->assertInstanceOf(Response::class, $response);
    }

    private function createShowController(
        Environment $twig,
        AbstractPostRepository $abstractPostRepository,
    ): ShowController {
        $breadCrumbsManager = $this->createMock(BreadCrumbsManager::class);
        $controller = new ShowController($breadCrumbsManager, $abstractPostRepository, $twig);

        return $controller;
    }
}
