<?php

namespace Harentius\BlogBundle\Sidebar;

use Harentius\BlogBundle\Entity\TagRepository;

class Tags
{
    public function __construct(
        private readonly TagRepository $tagRepository,
        private readonly int $sidebarTagsLimit,
        private readonly array $sidebarTagSizes,
    ) {
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
