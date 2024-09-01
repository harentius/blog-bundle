<?php

namespace Harentius\BlogBundle\Sidebar;

use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Entity\ArticleRepository;

class Archive
{
    public function __construct(private readonly ArticleRepository $articleRepository)
    {
    }

    public function getList(): array
    {
        /** @var Article[] $articles */
        $articles = $this->articleRepository->findBy(['published' => true], ['publishedAt' => 'DESC']);
        $list = [];

        foreach ($articles as $article) {
            $publishedAt = $article->getPublishedAt();
            $list[$publishedAt->format('Y')][$publishedAt->format('m')] = $publishedAt->format('F');
        }

        return $list;
    }
}
