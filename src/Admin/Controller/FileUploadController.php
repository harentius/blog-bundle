<?php

namespace Harentius\BlogBundle\Admin\Controller;

use Harentius\BlogBundle\Assets\Manager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FileUploadController
{
    /**
     * @var Manager
     */
    private $assetsManager;

    /**
     * @param Manager $assetsManager
     */
    public function __construct(Manager $assetsManager)
    {
        $this->assetsManager = $assetsManager;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        $assetFile = $this->assetsManager->handleUpload($request->files->get('file'));

        return new JsonResponse([
            'uri' => $assetFile->getUri(),
        ]);
    }
}
