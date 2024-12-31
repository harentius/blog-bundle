<?php

namespace Harentius\BlogBundle\API;

use Doctrine\ORM\EntityManagerInterface;
use Harentius\BlogBundle\Entity\Category;
use Harentius\BlogBundle\Entity\CategoryRepository;

class CategoryManager
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CategoryRepository $categoryRepository,
    ) {
    }

    public function ensureCategories(string $path): ?Category
    {
        $fragments = explode('/', trim($path, '/'));

        if (count($fragments) < 1) {
            return null;
        }

        $rootCategoryName = array_shift($fragments);
        $root = $this->categoryRepository->findOneBy([
            'name' => $rootCategoryName,
            'level' => 0,
        ]);

        if (!$root) {
            $root = Category::create($rootCategoryName);
            $this->entityManager->persist($root);
        }

        $parent = $root;
        foreach ($fragments as $fragment) {
            $match = false;
            foreach ($parent->getChildren() as $child) {
                if ($child->getName() === $fragment) {
                    $parent = $child;
                    $match = true;
                    break;
                }
            }

            if (!$match) {
                $category = Category::create($fragment);
                $category->setParent($parent);
                $this->entityManager->persist($category);
                $parent = $category;
            }
        }

        return $parent;
    }
}
