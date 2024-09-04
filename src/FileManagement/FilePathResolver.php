<?php

namespace Harentius\BlogBundle\FileManagement;

class FilePathResolver
{
    /**
     * @var string
     */
    private $webDir;

    private readonly string $assetsDir;

    /**
     * @param string $webDir
     */
    public function __construct($webDir)
    {
        $this->webDir = realpath($webDir);
        $this->assetsDir = 'assets';

        if (!$this->webDir) {
            throw new \InvalidArgumentException("Missing web directory '{$webDir}'");
        }
    }

    /**
     * @param string $type
     */
    public function assetPath($type): string
    {
        return $this->uriToPath($this->assetUri($type));
    }

    /**
     * @param string $type
     */
    public function assetUri($type): string
    {
        return "/{$this->assetsDir}/{$type}s";
    }

    /**
     * @param string $uri
     */
    public function uriToPath($uri): string
    {
        return "{$this->webDir}{$uri}";
    }

    /**
     * @param string $path
     */
    public function pathToUri($path): ?string
    {
        $prefix = "{$this->webDir}/{$this->assetsDir}/";

        if (str_starts_with($path, $prefix)) {
            return substr($path, strlen($this->webDir));
        }

        return null;
    }
}
