<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CoverImageExtension extends AbstractExtension
{
    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('cover_image_path', $this->getImagePath(...)),
        ];
    }

    public function getImagePath(string $articleSlug): ?string
    {
        return 'assets/' . $articleSlug . '/cover.png';
    }
}
