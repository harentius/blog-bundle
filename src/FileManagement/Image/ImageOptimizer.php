<?php

namespace Harentius\BlogBundle\FileManagement\Image;

use Harentius\BlogBundle\FileManagement\AssetFile;
use Harentius\BlogBundle\FileManagement\FilePathResolver;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;

class ImageOptimizer
{
    /**
     * @param string $targetBasePath
     */
    public function __construct(
        private readonly CacheManager $cacheManager,
        private readonly FilterManager $filterManager,
        private readonly DataManager $dataManager,
        private readonly FilePathResolver $assetsResolver,
        private $targetBasePath,
    ) {
    }

    /**
     * @param string $imageName
     * @return string
     */
    public function createPreviewIfNotExists($imageName)
    {
        $imagePreviewData = $this->extractPreviewData($imageName);

        return $this->resize($imagePreviewData);
    }

    private function resize(ImagePreview $imagePreviewData): string
    {
        $filter = 'preview';

        if (!$this->cacheManager->isStored($imagePreviewData->getTargetName(), $filter)) {
            $binary = $this->dataManager->find($filter, $imagePreviewData->getSourceUri());

            $filteredBinary = $this->filterManager->applyFilter($binary, $filter, [
                'filters' => [
                    'thumbnail' => [
                        'size' => [$imagePreviewData->getWidth(), $imagePreviewData->getHeight()],
                    ],
                ],
            ]);

            $this->cacheManager->store($filteredBinary, $imagePreviewData->getTargetName(), $filter);
        }

        return $this->assetsResolver->uriToPath($this->targetBasePath . $imagePreviewData->getTargetName());
    }

    /**
     * @param string $imageName
     */
    private function extractPreviewData($imageName): ImagePreview
    {
        // example: name_500x300.png
        $regexp = '/(?<name>[^\/]*?)(_(?<width>\d+)x(?<height>\d+))?(\.(?<extension>[0-9a-z]+))$/i';
        preg_match($regexp, $imageName, $imageNameParts);
        $requiredKeys = ['name', 'width', 'height', 'extension'];

        foreach ($requiredKeys as $key) {
            if (!isset($imageNameParts[$key])) {
                throw new \InvalidArgumentException(sprintf(
                    "Info about '%' can't be extracted from image name '%s'",
                    $key,
                    $imageName
                ));
            }
        }

        $sourcePath = $this->assetsResolver->assetUri(AssetFile::TYPE_IMAGE) . '/'
            . $imageNameParts['name']
            . '.' . $imageNameParts['extension']
        ;

        $imagePreviewData = new ImagePreview();
        $imagePreviewData
            ->setSourceUri($sourcePath)
            ->setTargetName($imageName)
            ->setWidth($imageNameParts['width'])
            ->setHeight($imageNameParts['height'])
        ;

        return $imagePreviewData;
    }
}
