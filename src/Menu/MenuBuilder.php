<?php

namespace Harentius\BlogBundle\Menu;

use Harentius\BlogBundle\Entity\PageRepository;
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
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @var string|null
     */
    private $homepageSlug;

    /**
     * @var PublicationUrlGenerator
     */
    private $publicationUrlGenerator;

    /**
     * @param FactoryInterface $factory
     * @param PageRepository $pageRepository
     * @param PublicationUrlGenerator $publicationUrlGenerator
     * @param string|null $homepageSlug
     */
    public function __construct(
        FactoryInterface $factory,
        PageRepository $pageRepository,
        PublicationUrlGenerator $publicationUrlGenerator,
        ?string $homepageSlug
    ) {
        $this->factory = $factory;
        $this->homepageSlug = $homepageSlug;
        $this->publicationUrlGenerator = $publicationUrlGenerator;
        $this->pageRepository = $pageRepository;
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

        $pages = $this->pageRepository->findForMainMenu($this->homepageSlug);

        foreach ($pages as $page) {
            $menu->addChild($page->getTitle(), [
                'uri' => $this->publicationUrlGenerator->generateUrl($page),
            ]);
        }

        return $menu;
    }
}
