<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\Breadcrumbs\BreadCrumbsManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Harentius\BlogBundle\Entity\AbstractPostRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowController extends AbstractController
{
    /**
     * @var BreadCrumbsManager
     */
    private $breadCrumbsManager;

    /**
     * @param BreadCrumbsManager $breadCrumbsManager
     */
    public function __construct(
        BreadCrumbsManager $breadCrumbsManager,
        readonly private AbstractPostRepository $abstractPostRepository,
    )
    {
        $this->breadCrumbsManager = $breadCrumbsManager;
    }

    public function __invoke(string $slug): Response
    {
        $post = $this->abstractPostRepository->findOneBy(['slug' => $slug]);

        if (!$post) {
            throw new NotFoundHttpException();
        }

        $this->breadCrumbsManager->buildPost($post);
        $class = get_class($post);
        $type = strtolower(substr($class, strrpos($class, '\\') + 1));

        return $this->render(sprintf('@HarentiusBlog/Show/%s.html.twig', $type), [
            'entity' => $post,
        ]);
    }
}
