<?php

namespace Harentius\BlogBundle;

use Harentius\BlogBundle\Assets\AssetFile;
use Harentius\BlogBundle\Assets\Resolver;
use Harentius\BlogBundle\Data\ImagePreview;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;

class ImageOptimizer
{
    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var FilterManager
     */
    private $filterManager;

    /**
     * @var DataManager
     */
    private $dataManager;

    /**
     * @var Resolver
     */
    private $assetsResolver;

    /**
     * @var string
     */
    private $targetBasePath;

    /**
     * @param CacheManager $cacheManager
     * @param FilterManager $filterManager
     * @param DataManager $dataManager
     * @param Resolver $assetsResolver
     * @param string $targetBasePath
     */
    public function __construct(
        CacheManager $cacheManager,
        FilterManager $filterManager,
        DataManager $dataManager,
        Resolver $assetsResolver,
        $targetBasePath
    ) {
        $this->cacheManager = $cacheManager;
        $this->filterManager = $filterManager;
        $this->dataManager = $dataManager;
        $this->assetsResolver = $assetsResolver;
        $this->targetBasePath = $targetBasePath;
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

    /**
     * @param ImagePreview $imagePreviewData
     * @return string
     */
    private function resize(ImagePreview $imagePreviewData)
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
     * @return ImagePreview
     */
    private function extractPreviewData($imageName)
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
