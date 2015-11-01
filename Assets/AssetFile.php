<?php

namespace Harentius\BlogBundle\Assets;

use Symfony\Component\HttpFoundation\File\File;

class AssetFile
{
    const TYPE_IMAGE = 'image';
    const TYPE_AUDIO = 'audio';
    const TYPE_OTHER = 'file';

    /**
     * @var File
     */
    private $file;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var int
     */
    private $type;

    /**
     * @var string
     */
    private $originalName;

    /**
     * @var array
     */
    private static $assetsTypesMap = [
        self::TYPE_IMAGE => [
            'image/jpeg' => ['jpeg', 'jpg', 'jpe'],
            'image/png' => ['png'],
            'image/gif' =>	['gif'],
            'image/tiff' => ['tiff', 'tif'],
        ],
        self::TYPE_AUDIO => [
            'audio/mpeg' => ['mpga', 'mp2', 'mp2a', 'mp3', 'm2a', 'm3a'],
            'audio/x-wav' => ['wav'],
        ],
        self::TYPE_OTHER => [
            'application/x-rar-compressed' => ['rar'],
            'application/x-rar' => ['rar'],
            'application/zip' => ['zip'],
            'application/x-tar' => ['tar'],
            'application/x-gzip' => ['gz'],
        ],
    ];

    /**
     * @param File $file
     * @param string $uri
     * @param int|null $fallbackType
     */
    public function __construct(File $file = null, $uri = null, $fallbackType = null)
    {
        if ($fallbackType !== null && !in_array($fallbackType, [self::TYPE_AUDIO, self::TYPE_IMAGE], true)) {
            throw new \InvalidArgumentException(sprintf("Unsupported '\$fallbackType' value '%s'", $fallbackType));
        }

        $this->setFile($file, $fallbackType);
        $this->uri = $uri;
    }

    /**
     * @param File $value
     * @param int|null $fallbackType
     */
    public function setFile(File $value = null, $fallbackType = null)
    {
        $this->file = $value;

        if ($this->file === null) {
            $this->type = null;

            return;
        }

        $fileMimeType = $this->file->getMimeType();

        foreach (self::$assetsTypesMap as $type => $mimeTypes) {
            foreach ($mimeTypes as $mimeType => $extensions) {
                if ($fileMimeType === $mimeType) {
                    $this->type = $type;
                    break 2;
                }
            }
        }

        if ($this->type === null && $fileMimeType === 'application/octet-stream' && $fallbackType !== null) {
            $this->type = $fallbackType;
        }
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $value
     */
    public function setUri($value)
    {
        $this->uri = $value;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setOriginalName($value)
    {
        $this->originalName = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * @return bool
     */
    public function isExtensionValid()
    {
        return $this->file && in_array(
            $this->file->getExtension(),
            self::$assetsTypesMap[$this->type][$this->file->getMimeType()]
        );
    }
}
