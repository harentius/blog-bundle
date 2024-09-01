<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\FileManagement\Image\ImageOptimizer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageOptimizationController
{
    public function __construct(private readonly ImageOptimizer $imageOptimizer)
    {
    }

    /**
     * For optimization, try_files should be set in nginx
     * Then BinaryFileResponse only once, when crete cache preview.
     */
    public function __invoke(string $imageName): BinaryFileResponse
    {
        try {
            $imagePath = $this->imageOptimizer->createPreviewIfNotExists($imageName);

            return new BinaryFileResponse($imagePath);
        } catch (\Exception) {
            throw new NotFoundHttpException(sprintf('File %s not found', $imageName));
        }
    }
}
