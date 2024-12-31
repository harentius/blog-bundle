<?php

namespace Harentius\BlogBundle\API;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager
{
    public function __construct(
        private readonly string $targetDir,
    ) {
    }

    public function create(UploadedFile $uploadedFile, string $path): void
    {
        $targetPath = $this->targetDir . '/' . $path;
        $dir = dirname($targetPath);
        $fileName = basename($targetPath);
        $uploadedFile->move($dir, $fileName);
    }

    public function delete(string $path): void
    {
        $filesystem = new Filesystem();
        $targetPath = $this->targetDir . '/' . $path;

        $filesystem->remove($targetPath);
    }
}
