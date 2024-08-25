<?php

namespace Harentius\BlogBundle\Breadcrumbs;

class BreadcrumbItem
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var string|null
     */
    private $url;

    public function __construct(string $text, ?string $url = null)
    {
        $this->text = $text;
        $this->url = $url;
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
