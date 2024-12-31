<?php

namespace Harentius\BlogBundle\API;

use Doctrine\ORM\EntityManagerInterface;
use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly CategoryManager $categoryManager,
        private readonly Security $security,
    ) {
    }

    public function upsert(Request $request): JsonResponse
    {
        if (!$request->headers->has('api-token')
            || !$this->security->isApiTokenValid($request->headers->get('api-token'))
        ) {
            return new JsonResponse(null, Response::HTTP_UNAUTHORIZED);
        }

        $content = json_decode($request->getContent(), true);
        $articleDTO = ArticleDTO::fromRequestContent($content);

        $article = $this->articleRepository->findOneBy(['slug' => $articleDTO->slug]);

        if (!$articleDTO->isValid()) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        if (!$article) {
            $article = new Article();
            $this->entityManager->persist($article);
        }

        $category = $this->categoryManager->ensureCategories($articleDTO->path);

        if (!$category) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        $article->update(
            $articleDTO->title,
            $articleDTO->slug,
            $articleDTO->content,
            $category,
            $articleDTO->metaDescription,
            $articleDTO->metaKeywords,
            $articleDTO->publishedAt,
        );
        $article->setPublished(true);

        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_OK);
    }

    public function delete(Request $request): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        if (!isset($content['slug'])) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        $slug = $content['slug'];
        $article = $this->articleRepository->findOneBy(['slug' => $slug]);

        if (!$article) {
            return new JsonResponse([
                'message' => "Article with slug {$slug} is not found.",
            ], Response::HTTP_NOT_MODIFIED);
        }

        $this->entityManager->remove($article);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
