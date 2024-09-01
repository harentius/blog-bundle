<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\Entity\Category;
use Harentius\BlogBundle\Entity\CategoryRepository;
use Harentius\BlogBundle\Sidebar\Archive;
use Harentius\BlogBundle\Sidebar\Tags;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class SidebarController
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var Archive
     */
    private $archive;

    /**
     * @var Tags
     */
    private $tags;

    /**
     * @param CategoryRepository $categoryRepository
     * @param Archive $archive
     * @param Tags $tags
     * @param Environment $twig
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        Archive $archive,
        Tags $tags,
        private readonly Environment $twig,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->archive = $archive;
        $this->tags = $tags;
    }

    /**
     * @param bool $showNumber
     * @return Response
     */
    public function categories($showNumber = true): Response
    {
        return new Response($this->twig->render('@HarentiusBlog/Sidebar/categories.html.twig', [
            'categories' => $this->categoryRepository->notEmptyChildrenHierarchy([
                'decorate' => true,
                'representationField' => 'slug',
                'html' => true,
                'nodeDecorator' => function ($node) use ($showNumber) {
                    /** @var Category $category */
                    $category = $node[0];

                    return sprintf('<a href="%s">%s</a>' . ($showNumber ? ' (%d)' : ''),
                        $this->urlGenerator->generate('harentius_blog_category', ['slug' => $category->getSlugWithParents()]),
                        $category->getName(),
                        $node['articles_number']
                    );
                },
            ]),
        ]));
    }

    /**
     * @return Response
     */
    public function archive(): Response
    {
        return new Response($this->twig->render('@HarentiusBlog/Sidebar/archive.html.twig', [
            'archivesList' => $this->archive->getList(),
        ]));
    }

    /**
     * @return Response
     */
    public function tags(): Response
    {
        return new Response($this->twig->render('@HarentiusBlog/Sidebar/tags.html.twig', [
            'tags' => $this->tags->getList(),
        ]));
    }
}
