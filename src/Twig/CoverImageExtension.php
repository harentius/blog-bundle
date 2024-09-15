<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Twig;

use Symfony\Component\Filesystem\Filesystem;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CoverImageExtension extends AbstractExtension
{
    public function __construct(
        private readonly string $targetDir,
    ) {
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('cover_image_path', $this->getImagePath(...)),
            new TwigFunction('cover_image_exists', $this->coverImageExists(...)),
        ];
    }

    public function getImagePath(string $articleSlug): ?string
    {
        return '/assets/' . $articleSlug . '/cover.png';
    }

    public function coverImageExists(string $articleSlug): bool
    {
        $filesystem = new Filesystem();
        $coverFilePath = $this->targetDir . '/' . $articleSlug . '/cover.png';

        return $filesystem->exists($coverFilePath);
    }
}
