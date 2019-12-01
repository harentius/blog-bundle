<?php

namespace Harentius\BlogBundle\Menu;

use Doctrine\ORM\EntityManagerInterface;
use Harentius\BlogBundle\Entity\Page;
use Harentius\BlogBundle\Router\PublicationUrlGenerator;
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
     * @var PublicationUrlGenerator
     */
    private $publicationUrlGenerator;

    /**
     * @param FactoryInterface $factory
     * @param EntityManagerInterface $em
     * @param PublicationUrlGenerator $publicationUrlGenerator
     * @param $homepageSlug
     */
    public function __construct(
        FactoryInterface $factory,
        EntityManagerInterface $em,
        PublicationUrlGenerator $publicationUrlGenerator,
        $homepageSlug
    ) {
        $this->factory = $factory;
        $this->em = $em;
        $this->homepageSlug = $homepageSlug;
        $this->publicationUrlGenerator = $publicationUrlGenerator;
    }

    /**
     * @return ItemInterface
     */
    public function createMainMenu()
    {
        $menu = $this->factory->createItem('root');

        $menu->setChildrenAttribute('class', 'navbar-nav');
        $menu
            ->addChild('About', ['route' => 'harentius_blog_page_about'])
            ->setLinkAttribute('class', 'nav-link')
        ;

        /** @var Page[] $pages */
        $pages = $this->em->getRepository('HarentiusBlogBundle:Page')
            ->findPublishedNotSlugOrdered($this->homepageSlug)
        ;

        foreach ($pages as $page) {
            $menu->addChild($page->getTitle(), [
                'uri' => $this->publicationUrlGenerator->generateUrl($page),
            ]);
        }

        return $menu;
    }
}
