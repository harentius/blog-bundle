<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\BreadCrumbsManager;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArchiveController extends AbstractController
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
     * @param string $year
     * @param null|string $month
     * @return Response
     */
    public function __invoke(Request $request, string $year, ?string $month = null)
    {
        $humanizedMonth = null;

        if ($month) {
            $humanizedMonth = $this->numberToMonth($month, $request->getLocale());
        }

        $this->breadCrumbsManager->buildArchive($year, $humanizedMonth);

        $articlesQuery = $this->articleRepository->findPublishedByYearMonthQuery($year, $month);
        $paginator = $this->paginator->paginate($request, $articlesQuery);

        return $this->render('@HarentiusBlog/Blog/list.html.twig', [
            'articles' => $paginator,
            'year' => $year,
            'month' => $month,
            'noIndex' => true,
            'hasToPaginate' => $paginator->getPageCount() > 1,
        ]);
    }

    /**
     * @param string $number
     * @param string $locale
     * @return string
     */
    private function numberToMonth($number, $locale)
    {
        $dateTime = \DateTime::createFromFormat('!m', $number);
        $formatter = \IntlDateFormatter::create(
            $locale,
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::NONE,
            $dateTime->getTimezone()->getName(),
            null,
            'LLLL'
        );

        return mb_convert_case($formatter->format($dateTime), MB_CASE_TITLE, 'UTF-8');
    }
}
