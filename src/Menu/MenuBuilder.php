<?php

namespace Harentius\BlogBundle\Menu;

use Harentius\BlogBundle\Entity\PageRepository;
use Harentius\BlogBundle\Router\PublicationUrlGenerator;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

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
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param FactoryInterface $factory
     * @param PageRepository $pageRepository
     * @param PublicationUrlGenerator $publicationUrlGenerator
     * @param RequestStack $requestStack
     * @param string|null $homepageSlug
     */
    public function __construct(
        FactoryInterface $factory,
        PageRepository $pageRepository,
        PublicationUrlGenerator $publicationUrlGenerator,
        RequestStack $requestStack,
        ?string $homepageSlug
    ) {
        $this->factory = $factory;
        $this->publicationUrlGenerator = $publicationUrlGenerator;
        $this->pageRepository = $pageRepository;
        $this->requestStack = $requestStack;
        $this->homepageSlug = $homepageSlug;
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
        $locale = $this->requestStack->getCurrentRequest()->getLocale();

        foreach ($pages as $page) {
            $menu->addChild($page->getTitle(), [
                'uri' => $this->publicationUrlGenerator->generateUrl($page, $locale),
            ]);
        }

        return $menu;
    }
}
