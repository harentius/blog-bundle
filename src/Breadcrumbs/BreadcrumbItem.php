<?php

namespace Harentius\BlogBundle\Breadcrumbs;

class BreadcrumbItem
{
    public function __construct(
        private readonly string $text,
        private readonly ?string $url = null,
    ) {
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }
}
