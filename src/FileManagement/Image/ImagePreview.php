<?php

namespace Harentius\BlogBundle\FileManagement\Image;

class ImagePreview
{
    /**
     * @var string
     */
    private $sourceUri;

    /**
     * @var string
     */
    private $targetName;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @return string
     */
    public function getSourceUri()
    {
        return $this->sourceUri;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSourceUri($value)
    {
        $this->sourceUri = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getTargetName()
    {
        return $this->targetName;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setTargetName($value)
    {
        $this->targetName = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setWidth($value)
    {
        $this->width = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setHeight($value)
    {
        $this->height = $value;

        return $this;
    }
}
