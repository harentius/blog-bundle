<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\BreadCrumbsManager;
use Harentius\BlogBundle\Entity\AbstractPost;
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
        $this->breadCrumbsManager->buildPost($post);
        $class = get_class($post);
        $type = strtolower(substr($class, strrpos($class, '\\') + 1));

        return $this->render(sprintf('@HarentiusBlog/Show/%s.html.twig', $type), [
            'entity' => $post,
        ]);
    }
}
