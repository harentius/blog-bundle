<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\Breadcrumbs\BreadCrumbsManager;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Entity\Tag;
use Harentius\BlogBundle\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TagController extends AbstractController
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
     * @param ArticleRepository $articleRepository
     * @param BreadCrumbsManager $breadCrumbsManager
     * @param Paginator $paginator
     */
    public function __construct(
        ArticleRepository $articleRepository,
        BreadCrumbsManager $breadCrumbsManager,
        Paginator $paginator
    ) {
        $this->articleRepository = $articleRepository;
        $this->breadCrumbsManager = $breadCrumbsManager;
        $this->paginator = $paginator;
    }

    /**
     * @param Request $request
     * @param Tag $tag
     * @return Response
     */
    public function __invoke(Request $request, Tag $tag): Response
    {
        $this->breadCrumbsManager->buildTag($tag);
        $articlesQuery = $this->articleRepository->findPublishedByTagQuery($tag);
        $paginator = $this->paginator->paginate($request, $articlesQuery);

        return $this->render('@HarentiusBlog/Blog/list.html.twig', [
            'articles' => $paginator,
            'parent' => $tag,
            'noIndex' => true,
            'hasToPaginate' => $paginator->getPageCount() > 1,
        ]);
    }
}
