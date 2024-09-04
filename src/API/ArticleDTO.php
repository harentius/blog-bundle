<?php

namespace Harentius\BlogBundle\API;

class ArticleDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $slug,
        public readonly string $path,
        public readonly string $content,
        public readonly string $metaDescription,
        public readonly string $metaKeywords,
        public readonly \DateTime $publishedAt,
    ) {
    }

    public static function fromRequestContent(array $content): self
    {
        return new self(
            $content['title'] ?? '',
            $content['slug'] ?? '',
            $content['path'] ?? '',
            $content['content'] ?? '',
            $content['metaDescription'] ?? '',
            $content['metaKeywords'] ?? '',
            isset($content['publishedAt']) ? new \DateTime($content['publishedAt']) : new \DateTime(),
        );
    }

    public function isValid(): bool
    {
        return $this->title && $this->path && $this->slug && $this->content;
    }
}
