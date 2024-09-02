<?php

namespace Harentius\BlogBundle\FileManagement;

use Symfony\Component\HttpFoundation\File\File;

class AssetFile
{
    public const TYPE_IMAGE = 'image';
    public const TYPE_AUDIO = 'audio';
    public const TYPE_OTHER = 'file';

    private ?File $file = null;

    /**
     * @var int
     */
    private $type;

    /**
     * @var string
     */
    private $originalName;

    private static array $assetsTypesMap = [
        self::TYPE_IMAGE => [
            'image/jpeg' => ['jpeg', 'jpg', 'jpe'],
            'image/png' => ['png'],
            'image/gif' => ['gif'],
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
     * @param string $uri
     * @param int|null $fallbackType
     */
    public function __construct(?File $file = null, private $uri = null, $fallbackType = null)
    {
        if ($fallbackType !== null && !in_array($fallbackType, [self::TYPE_AUDIO, self::TYPE_IMAGE], true)) {
            throw new \InvalidArgumentException(sprintf("Unsupported '\$fallbackType' value '%s'", $fallbackType));
        }

        $this->setFile($file, $fallbackType);
    }

    /**
     * @param int|null $fallbackType
     */
    public function setFile(?File $value = null, $fallbackType = null): void
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
    public function getFile(): ?\Symfony\Component\HttpFoundation\File\File
    {
        return $this->file;
    }

    /**
     * @param string $value
     */
    public function setUri($value): void
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
    public function setOriginalName($value): static
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

    public function isExtensionValid(): bool
    {
        return $this->file && in_array(
            $this->file->getExtension(),
            self::$assetsTypesMap[$this->type][$this->file->getMimeType()],
            true
        );
    }
}
