<?php

namespace Harentius\BlogBundle\Router;

use Doctrine\Common\Cache\CacheProvider;
use Harentius\BlogBundle\Entity\Category;
use Harentius\BlogBundle\Entity\CategoryRepository;

class CategorySlugProvider
{
    /**
     * @var CacheProvider
     */
    private $cache;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     * @param CacheProvider $cache
     */
    public function __construct(CategoryRepository $categoryRepository, CacheProvider $cache)
    {
        $this->categoryRepository = $categoryRepository;
        $this->cache = $cache;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $key = 'categories_slug';

        if ($this->cache->contains($key)) {
            return $this->cache->fetch($key);
        }

        /** @var Category[] $categories */
        $categories = $this->categoryRepository->findWithPublishedArticles();
        $categoriesSlugs = [];

        foreach ($categories as $category) {
            $slug = "/{$category->getSlug()}/";
            $parent = $category;

            /** @var Category|null $parent */
            while ($parent = $parent->getParent()) {
                $slug = "/{$parent->getSlug()}$slug";
            }

            $categoriesSlugs[$category->getId()] = $slug;
        }

        $this->cache->save($key, $categoriesSlugs);

        return $categoriesSlugs;
    }

    /**
     *
     */
    public function clearAll()
    {
        $this->cache->deleteAll();
    }
}
