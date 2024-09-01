<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\Breadcrumbs\BreadCrumbsManager;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Entity\CategoryRepository;
use Harentius\BlogBundle\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class CategoryController
{
    public function __construct(private readonly ArticleRepository $articleRepository, private readonly CategoryRepository $categoryRepository, private readonly BreadCrumbsManager $breadCrumbsManager, private readonly Paginator $paginator, private readonly Environment $twig)
    {
    }

    public function __invoke(Request $request, string $slug): Response
    {
        $explodedSlug = explode('/', $slug);
        $categorySlug = end($explodedSlug);
        $category = $this->categoryRepository->findOneBy(['slug' => $categorySlug]);

        if (!$category) {
            throw new NotFoundHttpException();
        }

        $this->breadCrumbsManager->buildCategory($category);
        $articlesQuery = $this->articleRepository->findPublishedByCategoryQuery($category);
        $paginator = $this->paginator->paginate($request, $articlesQuery);

        return new Response($this->twig->render('@HarentiusBlog/Blog/list.html.twig', [
            'articles' => $paginator,
            'parent' => $category,
            'hasToPaginate' => $paginator->getPageCount() > 1,
        ]));
    }
}
