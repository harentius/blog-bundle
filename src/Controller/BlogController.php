<?php

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Entity\Category;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class BlogController extends Controller
{
    const FILTRATION_TYPE_CATEGORY = 'category';
    const FILTRATION_TYPE_TAG = 'tag';

    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $homepage = $this->get('harentius_blog.homepage');
        $paginator = $this->knpPaginateCustomPerPage(
            $request,
            $homepage->getFeed(),
            $this->getParameter('harentius_blog.homepage.feed.number')
        );
        $currentPageNumber = $paginator->getCurrentPageNumber();

        return $this->render('HarentiusBlogBundle:Blog:index.html.twig', [
            'page' => $currentPageNumber === 1 ? $homepage->getPage() : null,
            'articles' => $paginator,
            'hasToPaginate' => $paginator->getPageCount() > 1,
            'noIndex' => $currentPageNumber > 1,
        ]);
    }

    /**
     * @param Request $request
     * @param string $filtrationType
     * @param string $criteria
     * @return Response
     */
    public function listAction(Request $request, $filtrationType, $criteria)
    {
        $articlesRepository = $this->getDoctrine()->getRepository('HarentiusBlogBundle:Article');

        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $noIndex = false;

        switch ($filtrationType) {
            case self::FILTRATION_TYPE_CATEGORY:
                $category = $this->getDoctrine()->getRepository('HarentiusBlogBundle:Category')
                    ->find($criteria)
                ;

                if (!$category) {
                    throw $this->createNotFoundException('Category not found');
                }

                $parent = $category;
                $this->addCategoryHierarchyToBreadcrumbs($category, $breadcrumbs);
                $articlesQuery = $articlesRepository->findPublishedByCategoryQuery($category);
                break;
            case self::FILTRATION_TYPE_TAG:
                $tag = $this->getDoctrine()->getRepository('HarentiusBlogBundle:Tag')
                    ->findOneBy(['slug' => $criteria])
                ;

                if (!$tag) {
                    throw $this->createNotFoundException('Tag not found');
                }

                $parent = $tag;
                $breadcrumbs->addItem($tag->getName());
                $articlesQuery = $articlesRepository->findPublishedByTagQuery($tag);
                $noIndex = true;
                break;
            default:
                throw $this->createNotFoundException('Unknown filtration type');
        }

        $breadcrumbs->prependItem('Homepage', $this->generateUrl('harentius_blog_homepage'));
        $paginator = $this->knpPaginate($request, $articlesQuery);

        return $this->render('HarentiusBlogBundle:Blog:list.html.twig', [
            'articles' => $paginator,
            'parent' => $parent,
            'noIndex' => $noIndex,
            'hasToPaginate' => $paginator->getPageCount() > 1,
        ]);
    }

    /**
     * @param Request $request
     * @param string $year
     * @param null|string $month
     * @return Response
     */
    public function archiveAction(Request $request, $year, $month = null)
    {
        $articlesRepository = $this->getDoctrine()->getRepository('HarentiusBlogBundle:Article');

        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem('Homepage', $this->generateUrl('harentius_blog_homepage'));
        $breadcrumbs->addItem($year, $this->generateUrl('harentius_blog_archive_year', ['year' => $year]));

        $articlesQuery = $articlesRepository->findPublishedByYearMonthQuery($year, $month);
        $paginator = $this->knpPaginate($request, $articlesQuery);

        if ($month) {
            $month = $this->numberToMonth($month, $request->getLocale());
            $breadcrumbs->addItem($month);
        }

        return $this->render('HarentiusBlogBundle:Blog:list.html.twig', [
            'articles' => $paginator,
            'year' => $year,
            'month' => $month,
            'noIndex' => true,
            'hasToPaginate' => $paginator->getPageCount() > 1,
        ]);
    }

    /**
     * @param string $slug
     * @return Response
     */
    public function showAction($slug)
    {
        $entity = $this->getDoctrine()->getRepository('HarentiusBlogBundle:Article')
            ->findOneBy(['slug' => $slug, 'published' => true])
        ;

        $breadcrumbs = $this->get('white_october_breadcrumbs');

        if ($entity) {
            $this->addCategoryHierarchyToBreadcrumbs($entity->getCategory(), $breadcrumbs);
            $this->get('harentius_blog.views_counter')->processArticle($entity);
        } else {
            $entity = $this->getDoctrine()->getRepository('HarentiusBlogBundle:Page')
                ->findOneBy(['slug' => $slug, 'published' => true])
            ;

            if (!$entity) {
                throw $this->createNotFoundException(sprintf("Page '%s' not found", $slug));
            }
        }

        $breadcrumbs->addItem($entity->getTitle());
        $breadcrumbs->prependItem('Homepage', $this->generateUrl('harentius_blog_homepage'));
        $class = get_class($entity);
        $type = strtolower(substr($class, strrpos($class, '\\') + 1));

        return $this->render(sprintf('HarentiusBlogBundle:Blog:show_%s.html.twig', $type), [
            'entity' => $entity,
        ]);
    }

    /**
     * @param Article $article
     * @param string $type
     * @return Response
     */
    public function rateAction(Article $article, $type = 'like')
    {
        return $this->get('harentius_blog.rating')->rate(new Response(), $article, $type);
    }

    /**
     * @return Response
     */
    public function feedAction()
    {
        return new Response($this->get('harentius_blog.feed')->get());
    }

    /**
     * @param Category $category
     * @param Breadcrumbs $breadcrumbs
     */
    private function addCategoryHierarchyToBreadcrumbs(Category $category, Breadcrumbs $breadcrumbs)
    {
        do {
            $breadcrumbs->prependItem(
                $category->getName(),
                $this->generateUrl("harentius_blog_category_{$category->getId()}")
            );
        } while ($category = $category->getParent());
    }

    /**
     * @param Request $request
     * @param mixed $target
     * @param array $options
     * @return SlidingPagination
     */
    private function knpPaginate(Request $request, $target, array $options = [])
    {
        $maxResults = $this->getParameter('harentius_blog.list.posts_per_page');

        return $this->knpPaginateCustomPerPage($request, $target, $maxResults, $options);
    }

    /**
     * @param Request $request
     * @param mixed $target
     * @param $maxResults
     * @param array $options
     * @return SlidingPagination
     */
    private function knpPaginateCustomPerPage(Request $request, $target, $maxResults, array $options = [])
    {
        /** @var Controller $this */
        if (!isset($options['pageParameterName'])) {
            $options['pageParameterName'] = 'page';
        }

        /** @var PaginatorInterface $paginator */
        $paginator = $this->get('knp_paginator');
        $page = max(1, (int) $request->query->get($options['pageParameterName'], 1));
        /** @var SlidingPagination $pagination */
        $pagination = $paginator->paginate($target, $page, $maxResults, $options);

        return $pagination;
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
