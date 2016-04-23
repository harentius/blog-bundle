<?php

namespace Harentius\BlogBundle\Menu;

use Doctrine\ORM\EntityManagerInterface;
use Harentius\BlogBundle\Entity\Page;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var string
     */
    private $homepageSlug;

    /**
     * @param FactoryInterface $factory
     * @param EntityManagerInterface $em
     * @param $homepageSlug
     */
    public function __construct(
        FactoryInterface $factory,
        EntityManagerInterface $em,
        $homepageSlug
    ) {
        $this->factory = $factory;
        $this->em = $em;
        $this->homepageSlug = $homepageSlug;
    }

    /**
     * @return ItemInterface
     */
    public function createMainMenu()
    {
        /** @var Page[] $pages */
        $pages = $this->em->getRepository('HarentiusBlogBundle:Page')
            ->findPublishedNotSlugOrdered($this->homepageSlug)
        ;
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('About', [
            'route' => 'harentius_blog_page_about',
        ]);

        foreach ($pages as $page) {
            $menu->addChild($page->getTitle(), [
                'route' => 'harentius_blog_show',
                'routeParameters' => ['slug' => $page->getSlug()],
            ]);
        }

        return $menu;
    }
}
