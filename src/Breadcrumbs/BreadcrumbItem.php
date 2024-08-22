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

    public function __construct(string $name, ?string $link = null)
    {
        $this->text = $name;
        $this->url = $link;
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
