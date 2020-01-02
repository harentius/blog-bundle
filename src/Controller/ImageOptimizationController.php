<?php

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\FileManagement\Image\ImageOptimizer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageOptimizationController
{
    /**
     * @var ImageOptimizer
     */
    private $imageOptimizer;

    /**
     * @param ImageOptimizer $imageOptimizer
     */
    public function __construct(ImageOptimizer $imageOptimizer)
    {
        $this->imageOptimizer = $imageOptimizer;
    }

    /**
     * For optimization, try_files should be set in nginx
     * Then BinaryFileResponse only once, when crete cache preview.
     *
     * @param string $imageName
     * @return Response
     */
    public function __invoke($imageName)
    {
        try {
            $imagePath = $this->imageOptimizer->createPreviewIfNotExists($imageName);

            return new BinaryFileResponse($imagePath);
        } catch (\Exception $e) {
            throw new NotFoundHttpException(sprintf('File %s not found', $imageName));
        }
    }
}
