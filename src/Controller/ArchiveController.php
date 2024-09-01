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
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var BreadCrumbsManager
     */
    private $breadCrumbsManager;

    /**
     * @param ArticleRepository $articleRepository
     * @param BreadCrumbsManager $breadCrumbsManager
     * @param Paginator $paginator
     * @param Environment $twig
     */
    public function __construct(
        ArticleRepository $articleRepository,
        BreadCrumbsManager $breadCrumbsManager,
        Paginator $paginator,
        private readonly Environment $twig,
    ) {
        $this->articleRepository = $articleRepository;
        $this->breadCrumbsManager = $breadCrumbsManager;
        $this->paginator = $paginator;
    }

    /**
     * @param Request $request
     * @param string $year
     * @param null|string $month
     * @return Response
     */
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

    /**
     * @param string $number
     * @return string
     */
    private function numberToMonth($number): string
    {
        $dateTime = \DateTime::createFromFormat('!m', $number);

        return $dateTime->format('F');
    }
}
