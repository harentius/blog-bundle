<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\BreadCrumbsManager;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Entity\CategoryRepository;
use Harentius\BlogBundle\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var BreadCrumbsManager
     */
    private $breadCrumbsManager;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     * @param BreadCrumbsManager $breadCrumbsManager
     * @param Paginator $paginator
     */
    public function __construct(
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        BreadCrumbsManager $breadCrumbsManager,
        Paginator $paginator
    ) {
        $this->articleRepository = $articleRepository;
        $this->breadCrumbsManager = $breadCrumbsManager;
        $this->paginator = $paginator;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return Response
     */
    public function __invoke(Request $request, string $slug): Response
    {
        $explodedSlug = explode('/', $slug);
        $categorySlug = end($explodedSlug);
        $category = $this->categoryRepository->findOneBy(['slug' => $categorySlug]);

        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        $this->breadCrumbsManager->buildCategory($category);
        $articlesQuery = $this->articleRepository->findPublishedByCategoryQuery($category);
        $paginator = $this->paginator->paginate($request, $articlesQuery);

        return $this->render('@HarentiusBlog/Blog/list.html.twig', [
            'articles' => $paginator,
            'parent' => $category,
            'hasToPaginate' => $paginator->getPageCount() > 1,
        ]);
    }
}
