<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Controller;

use Harentius\BlogBundle\Controller\SidebarController;
use Harentius\BlogBundle\Entity\CategoryRepository;
use Harentius\BlogBundle\Sidebar\Archive;
use Harentius\BlogBundle\Sidebar\Tags;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
                'archivesList' => ['list'],
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
            ->willReturn(['list'])
        ;
        $tags = $this->createMock(Tags::class);
        $tags
            ->method('getList')
            ->willReturn('list')
        ;

        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $controller = new SidebarController($categoryRepository, $archive, $tags, $twig, $urlGenerator);

        return $controller;
    }
}
