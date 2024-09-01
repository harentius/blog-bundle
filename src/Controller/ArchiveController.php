<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\Breadcrumbs\BreadCrumbsManager;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ArchiveController
{
    public function __construct(private readonly ArticleRepository $articleRepository, private readonly BreadCrumbsManager $breadCrumbsManager, private readonly Paginator $paginator, private readonly Environment $twig)
    {
    }

    public function __invoke(Request $request, string $year, ?string $month = null): Response
    {
        $humanizedMonth = null;

        if ($month) {
            $humanizedMonth = $this->numberToMonth($month);
        }

        $this->breadCrumbsManager->buildArchive($year, $humanizedMonth);

        $articlesQuery = $this->articleRepository->findPublishedByYearMonthQuery($year, $month);
        $paginator = $this->paginator->paginate($request, $articlesQuery);

        return new Response($this->twig->render('@HarentiusBlog/Blog/list.html.twig', [
            'articles' => $paginator,
            'year' => $year,
            'month' => $humanizedMonth,
            'noIndex' => true,
            'hasToPaginate' => $paginator->getPageCount() > 1,
        ]));
    }

    private function numberToMonth(string $number): string
    {
        $dateTime = \DateTime::createFromFormat('!m', $number);

        return $dateTime->format('F');
    }
}
