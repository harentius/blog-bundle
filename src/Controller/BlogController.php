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
}
