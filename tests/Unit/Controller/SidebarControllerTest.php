<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Controller;

use Harentius\BlogBundle\Controller\SidebarController;
use Harentius\BlogBundle\Entity\CategoryRepository;
use Harentius\BlogBundle\Sidebar\Archive;
use Harentius\BlogBundle\Sidebar\Tags;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class SidebarControllerTest extends TestCase
{
    public function testCategories(): void
    {
        $twig = $this->createMock(Environment::class);
        $twig
            ->expects($this->once())
            ->method('render')
            ->with('@HarentiusBlog/Sidebar/categories.html.twig', [
                'categories' => 'categories',
            ])
        ;
        $sidebarController = $this->createSidebarController($twig);
        $response = $sidebarController->categories();
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testArchive(): void
    {
        $twig = $this->createMock(Environment::class);
        $twig
            ->expects($this->once())
            ->method('render')
            ->with('@HarentiusBlog/Sidebar/archive.html.twig', [
                'archivesList' => 'list',
            ])
        ;
        $sidebarController = $this->createSidebarController($twig);
        $response = $sidebarController->archive();
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testTags(): void
    {
        $twig = $this->createMock(Environment::class);
        $twig
            ->expects($this->once())
            ->method('render')
            ->with('@HarentiusBlog/Sidebar/tags.html.twig', [
                'tags' => 'list',
            ])
        ;
        $sidebarController = $this->createSidebarController($twig);
        $response = $sidebarController->tags();
        $this->assertInstanceOf(Response::class, $response);
    }

    private function createSidebarController(Environment $twig): SidebarController
    {
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $categoryRepository
            ->method('notEmptyChildrenHierarchy')
            ->willReturn('categories')
        ;
        $archive = $this->createMock(Archive::class);
        $archive
            ->method('getList')
            ->willReturn('list')
        ;
        $tags = $this->createMock(Tags::class);
        $tags
            ->method('getList')
            ->willReturn('list')
        ;

        $controller = new SidebarController($categoryRepository, $archive, $tags);
        $container = new Container();
        $container->set('twig', $twig);
        $controller->setContainer($container);

        return $controller;
    }
}
