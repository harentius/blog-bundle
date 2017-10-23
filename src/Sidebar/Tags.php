<?php

namespace Harentius\BlogBundle\Sidebar;

use Harentius\BlogBundle\Entity\TagRepository;

class Tags
{
    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * @var int
     */
    private $sidebarTagsLimit;

    /**
     * @var array
     */
    private $sidebarTagSizes;

    /**
     * @param TagRepository $tagRepository
     * @param int $sidebarTagsLimit
     * @param array $sidebarTagsSize
     */
    public function __construct(TagRepository $tagRepository, $sidebarTagsLimit, $sidebarTagsSize)
    {
        $this->tagRepository = $tagRepository;
        $this->sidebarTagsLimit = $sidebarTagsLimit;
        $this->sidebarTagSizes = $sidebarTagsSize;
    }

    /**
     * @return array
     */
    public function getList()
    {
        $tags = $this->tagRepository->findMostPopularLimited($this->sidebarTagsLimit);

        if (!$tags) {
            return $tags;
        }

        $maxWeight = $tags[0]['weight'];

        foreach ($tags as $key => $tag) {
            $percentage = 100;
            $minDiff = 1;

            foreach ($this->sidebarTagSizes as $tagPercent) {
                if (($diff = abs($tag['weight'] / $maxWeight - $tagPercent / 100)) < $minDiff) {
                    $minDiff = $diff;
                    $percentage = $tagPercent;
                }
            }

            $tags[$key]['percentage'] = $percentage;
        }

        return $tags;
    }
}
