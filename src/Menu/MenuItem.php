<?php

namespace Harentius\BlogBundle\Menu;

class MenuItem
{
    public function __construct(private readonly string $text, private readonly string $url)
    {
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
