<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\Breadcrumbs\BreadCrumbsManager;
use Harentius\BlogBundle\Entity\AbstractPostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class ShowController
{
    public function __construct(private readonly BreadCrumbsManager $breadCrumbsManager, private readonly AbstractPostRepository $abstractPostRepository, private readonly Environment $twig)
    {
    }

    public function __invoke(string $slug): Response
    {
        $post = $this->abstractPostRepository->findOneBy(['slug' => $slug]);

        if (!$post) {
            throw new NotFoundHttpException();
        }

        $this->breadCrumbsManager->buildPost($post);
        $class = $post::class;
        $type = strtolower(substr($class, strrpos($class, '\\') + 1));

        return new Response($this->twig->render(sprintf('@HarentiusBlog/Show/%s.html.twig', $type), [
            'entity' => $post,
        ]));
    }
}
