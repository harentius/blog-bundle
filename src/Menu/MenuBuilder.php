<?php

namespace Harentius\BlogBundle\Menu;

use Harentius\BlogBundle\Entity\PageRepository;
use Harentius\BlogBundle\Router\PublicationUrlGenerator;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder
{
    public function __construct(private readonly PageRepository $pageRepository, private readonly PublicationUrlGenerator $publicationUrlGenerator, private readonly RequestStack $requestStack, private readonly ?string $homepageSlug)
    {
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
