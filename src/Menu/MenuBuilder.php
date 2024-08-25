<?php

namespace Harentius\BlogBundle\Menu;

use Harentius\BlogBundle\Entity\PageRepository;
use Harentius\BlogBundle\Router\PublicationUrlGenerator;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder
{
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

    public function __construct(
        PageRepository $pageRepository,
        PublicationUrlGenerator $publicationUrlGenerator,
        RequestStack $requestStack,
        ?string $homepageSlug
    ) {
        $this->publicationUrlGenerator = $publicationUrlGenerator;
        $this->pageRepository = $pageRepository;
        $this->requestStack = $requestStack;
        $this->homepageSlug = $homepageSlug;
    }

    public function getMainMenuItems(): array
    {
        $pages = $this->pageRepository->findForMainMenu($this->homepageSlug);
        $locale = $this->requestStack->getCurrentRequest()->getLocale();

        $menuItems = [];

        foreach ($pages as $page) {
            $menuItems[] = new MenuItem(
                $page->getTitle(),
                $this->publicationUrlGenerator->generateUrl($page, $locale)
            );
        }

        return $menuItems;
    }
}
