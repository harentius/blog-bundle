<?php

namespace Harentius\BlogBundle\FileManagement;

class FilePathResolver
{
    /**
     * @var string
     */
    private $webDir;

    /**
     * @var string
     */
    private $assetsDir;

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
     * @return string
     */
    public function assetPath($type)
    {
        return $this->uriToPath($this->assetUri($type));
    }

    /**
     * @param string $type
     * @return string
     */
    public function assetUri($type)
    {
        return "/{$this->assetsDir}/{$type}s";
    }

    /**
     * @param string $uri
     * @return string
     */
    public function uriToPath($uri)
    {
        return "{$this->webDir}{$uri}";
    }

    /**
     * @param string $path
     * @return string|null
     */
    public function pathToUri($path)
    {
        $prefix = "{$this->webDir}/{$this->assetsDir}/";

        if (strpos($path, $prefix) === 0) {
            return substr($path, strlen($this->webDir));
        }

        return null;
    }
}
