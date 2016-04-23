<?php

namespace Harentius\BlogBundle\Sidebar;

use Harentius\BlogBundle\Entity\CategoryRepository;

class Categories
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param array $options
     * @return array
     */
    public function getList(array $options = [])
    {
        return $this->categoryRepository->notEmptyChildrenHierarchy($options);
    }
}
