<?php

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\BreadCrumbsManager;
use Harentius\BlogBundle\Entity\AbstractPost;
use Harentius\BlogBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ShowController extends AbstractController
{
    /**
     * @var BreadCrumbsManager
     */
    private $breadCrumbsManager;

    /**
     * @param BreadCrumbsManager $breadCrumbsManager
     */
    public function __construct(BreadCrumbsManager $breadCrumbsManager)
    {
        $this->breadCrumbsManager = $breadCrumbsManager;
    }

    /**
     * @param AbstractPost $post
     * @return Response
     */
    public function __invoke(AbstractPost $post): Response
    {
        // TODO
        if ($post instanceof Article) {
            $this->get('harentius_blog.views_counter')->processArticle($post);
        }

        $this->breadCrumbsManager->buildPost($post);
        $class = get_class($post);
        $type = strtolower(substr($class, strrpos($class, '\\') + 1));

        return $this->render(sprintf('@HarentiusBlog/Blog/show_%s.html.twig', $type), [
            'entity' => $post,
        ]);
    }
}
