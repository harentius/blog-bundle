<?php

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SidebarController extends Controller
{
    /**
     * @param bool $showNumber
     * @return Response
     */
    public function categoriesAction($showNumber = true)
    {
        return $this->render('@HarentiusBlog/Sidebar/categories.html.twig', [
            'categories' => $this->getDoctrine()->getRepository(Category::class)->notEmptyChildrenHierarchy([
                'decorate' => true,
                'representationField' => 'slug',
                'html' => true,
                'nodeDecorator' => function ($node) use ($showNumber) {
                    // Silent missing IDE warning
                    return sprintf('<a href=' . '"%s">%s</a>' . ($showNumber ? ' (%d)' : ''),
                        $this->generateUrl('harentius_blog_category', ['slug' => $node['slug']]),
                        $node['name'],
                        $node['articles_number']
                    );
                },
            ]),
        ]);
    }

    /**
     * @return Response
     */
    public function archiveAction()
    {
        return $this->render('@HarentiusBlog/Sidebar/archive.html.twig', [
            'archivesList' => $this->get('harentius_blog.sidebar.archive')->getList(),
        ]);
    }

    /**
     * @return Response
     */
    public function tagsAction()
    {
        return $this->render('@HarentiusBlog/Sidebar/tags.html.twig', [
            'tags' => $this->get('harentius_blog.sidebar.tags')->getList(),
        ]);
    }
}
