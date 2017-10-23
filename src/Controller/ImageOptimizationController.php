<?php

namespace Harentius\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageOptimizationController extends Controller
{
    /**
     * For optimization, try_files should be set in nginx
     * Then BinaryFileResponse only once, when crete cache preview.
     *
     * @param string $imageName
     * @return Response
     */
    public function resizeAction($imageName)
    {
        try {
            $imageOptimizer = $this->get('harentius_blog.image_optimizer');
            $imagePath = $imageOptimizer->createPreviewIfNotExists($imageName);

            return new BinaryFileResponse($imagePath);
        } catch (\Exception $e) {
            throw new NotFoundHttpException(sprintf('File %s not found', $imageName));
        }
    }
}
