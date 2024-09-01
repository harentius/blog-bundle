<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ReadMoreExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('read_more', $this->readMore(...), ['is_safe' => ['html']]),
        ];
    }

    public function readMore(string $content, ?string $url = null): string
    {
        if (($length = strpos($content, '<!--more-->')) !== false) {
            $content = substr($content, 0, $length);
        }

        if ($url !== null) {
            $content .= '<a href="' . $url . '">[..]</a>';
        }

        return $content;
    }
}
