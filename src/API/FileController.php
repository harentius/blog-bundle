<?php

namespace Harentius\BlogBundle\API;

use Gedmo\Mapping\Annotation\Uploadable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FileController
{
    public function __construct(
        private readonly FileManager $fileManager,
        private readonly Security $security,
    ) {
    }

    public function upload(Request $request): JsonResponse
    {
        if (!$request->headers->has('api-token')
            || !$this->security->isApiTokenValid($request->headers->get('api-token'))
        ) {
            return new JsonResponse(null, Response::HTTP_UNAUTHORIZED);
        }

        /** @var ?UploadedFile $file */
        $file = $request->files->get('file');

        if (!$file) {
            return new JsonResponse('File is empty', Response::HTTP_BAD_REQUEST);
        }

        $filePath = $file->getClientOriginalPath();

        if (!$filePath) {
            return new JsonResponse('File original path is empty', Response::HTTP_BAD_REQUEST);
        }

        $this->fileManager->create($file, $filePath);

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
