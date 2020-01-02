<?php

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\Entity\Category;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class BlogController extends AbstractController
{
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

        return $this->render('@HarentiusBlog/Blog/index.html.twig', [
            'page' => $currentPageNumber === 1 ? $homepage->getPage() : null,
            'articles' => $paginator,
            'hasToPaginate' => $paginator->getPageCount() > 1,
            'noIndex' => $currentPageNumber > 1,
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

        return $this->render(sprintf('@HarentiusBlog/Blog/show_%s.html.twig', $type), [
            'entity' => $entity,
        ]);
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
                $this->generateUrl('harentius_blog_category', ['slug' => $category->getSlugWithParents()])
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
}
