<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit;

use Harentius\BlogBundle\BreadCrumbsManager;
use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Entity\Category;
use Harentius\BlogBundle\Entity\Tag;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use WhiteOctober\BreadcrumbsBundle\Model\SingleBreadcrumb;

class BreadCrumbsManagerTest extends TestCase
{
    public function testBuildCategory(): void
    {
        /** @var Breadcrumbs|SingleBreadcrumb[] $breadCrumbs */
        $breadCrumbs = new Breadcrumbs();
        $breadCrumbsManager = $this->createBreadCrumbsManager($breadCrumbs);
        $category = new Category();
        $category->setName('Category Name');

        $breadCrumbsManager->buildCategory($category);

        $this->assertEquals('Homepage', $breadCrumbs[0]->text);
        $this->assertEquals('Category Name', $breadCrumbs[1]->text);
    }

    public function testBuildCategoryWithParent(): void
    {
        /** @var Breadcrumbs|SingleBreadcrumb[] $breadCrumbs */
        $breadCrumbs = new Breadcrumbs();
        $breadCrumbsManager = $this->createBreadCrumbsManager($breadCrumbs);

        $parentCategory = new Category();
        $parentCategory->setName('Parent Category Name');

        $category = new Category();
        $category
            ->setName('Category Name')
            ->setParent($parentCategory)
        ;

        $breadCrumbsManager->buildCategory($category);

        $this->assertEquals('Homepage', $breadCrumbs[0]->text);
        $this->assertEquals('Parent Category Name', $breadCrumbs[1]->text);
        $this->assertEquals('Category Name', $breadCrumbs[2]->text);
    }

    public function testBuildTag(): void
    {
        /** @var Breadcrumbs|SingleBreadcrumb[] $breadCrumbs */
        $breadCrumbs = new Breadcrumbs();
        $breadCrumbsManager = $this->createBreadCrumbsManager($breadCrumbs);
        $tag = new Tag();
        $tag->setName('Tag Name');

        $breadCrumbsManager->buildTag($tag);

        $this->assertEquals('Homepage', $breadCrumbs[0]->text);
        $this->assertEquals('Tag Name', $breadCrumbs[1]->text);
    }

    public function testBuildArchive(): void
    {
        /** @var Breadcrumbs|SingleBreadcrumb[] $breadCrumbs */
        $breadCrumbs = new Breadcrumbs();
        $breadCrumbsManager = $this->createBreadCrumbsManager($breadCrumbs);

        $breadCrumbsManager->buildArchive('2018', 'April');

        $this->assertEquals('Homepage', $breadCrumbs[0]->text);
        $this->assertEquals('2018', $breadCrumbs[1]->text);
        $this->assertEquals('April', $breadCrumbs[2]->text);
    }

    public function testBuildPost(): void
    {
        /** @var Breadcrumbs|SingleBreadcrumb[] $breadCrumbs */
        $breadCrumbs = new Breadcrumbs();
        $breadCrumbsManager = $this->createBreadCrumbsManager($breadCrumbs);

        $category = new Category();
        $category->setName('Category Name');
        $article = new Article();
        $article
            ->setCategory($category)
            ->setTitle('Article Title')
        ;

        $breadCrumbsManager->buildPost($article);

        $this->assertEquals('Homepage', $breadCrumbs[0]->text);
        $this->assertEquals('Category Name', $breadCrumbs[1]->text);
        $this->assertEquals('Article Title', $breadCrumbs[2]->text);
    }

    private function createBreadCrumbsManager(Breadcrumbs $breadcrumbs): BreadCrumbsManager
    {
        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);

        return new BreadCrumbsManager($breadcrumbs, $urlGenerator);
    }
}
