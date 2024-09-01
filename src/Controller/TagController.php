<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\Breadcrumbs\BreadCrumbsManager;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Entity\TagRepository;
use Harentius\BlogBundle\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class TagController
{
    public function __construct(private readonly ArticleRepository $articleRepository, private readonly BreadCrumbsManager $breadCrumbsManager, private readonly TagRepository $tagRepository, private readonly Paginator $paginator, private readonly Environment $twig)
    {
    }

    public function __invoke(Request $request, string $slug): Response
    {
        $tag = $this->tagRepository->findOneBy(['slug' => $slug]);

        if (!$tag) {
            throw new NotFoundHttpException();
        }

        $this->breadCrumbsManager->buildTag($tag);
        $articlesQuery = $this->articleRepository->findPublishedByTagQuery($tag);
        $paginator = $this->paginator->paginate($request, $articlesQuery);

        return new Response($this->twig->render('@HarentiusBlog/Blog/list.html.twig', [
            'articles' => $paginator,
            'parent' => $tag,
            'noIndex' => true,
            'hasToPaginate' => $paginator->getPageCount() > 1,
        ]));
    }
}
