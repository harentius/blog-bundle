<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Controller;

use Harentius\BlogBundle\Controller\ImageOptimizationController;
use Harentius\BlogBundle\FileManagement\Image\ImageOptimizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageOptimizationControllerTest extends TestCase
{
    public function testInvoke(): void
    {
        $filePath = __FILE__;
        $imageOptimizer = $this->createMock(ImageOptimizer::class);
        $imageOptimizer
            ->method('createPreviewIfNotExists')
            ->willReturn($filePath)
        ;
        $imageOptimizationController = $this->createImageOptimizationController($imageOptimizer);

        $response = $imageOptimizationController('image_name');
        $this->assertInstanceOf(BinaryFileResponse::class, $response);
        $this->assertSame($filePath, $response->getFile()->getPathname());
    }

    public function testInvokeWithException(): void
    {
        $imageOptimizer = $this->createMock(ImageOptimizer::class);
        $imageOptimizationController = $this->createImageOptimizationController($imageOptimizer);

        $this->expectException(NotFoundHttpException::class);
        $imageOptimizationController('image_name');
    }

    private function createImageOptimizationController(ImageOptimizer $imageOptimizer): ImageOptimizationController
    {
        return new ImageOptimizationController($imageOptimizer);
    }
}
