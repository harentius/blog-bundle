<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\Homepage;
use Harentius\BlogBundle\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomepageController
{
    /**
     * @var Homepage
     */
    private $homepage;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var int
     */
    private $homepageFeedPostsCount;

    /**
     * @param Homepage $homepage
     * @param Paginator $paginator
     * @param int $homepageFeedPostsCount
     */
    public function __construct(
        Homepage $homepage,
        Paginator $paginator,
        int $homepageFeedPostsCount,
        private readonly Environment $twig,
    )
    {
        $this->homepage = $homepage;
        $this->paginator = $paginator;
        $this->homepageFeedPostsCount = $homepageFeedPostsCount;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $paginator = $this->paginator->paginate($request, $this->homepage->getFeedQueryBuilder(), [], $this->homepageFeedPostsCount);
        $currentPageNumber = $paginator->getCurrentPageNumber();

        return new Response($this->twig->render('@HarentiusBlog/Blog/index.html.twig', [
            'page' => $currentPageNumber === 1 ? $this->homepage->getPage() : null,
            'articles' => $paginator,
            'hasToPaginate' => $paginator->getPageCount() > 1,
            'noIndex' => $currentPageNumber > 1,
        ]));
    }
}
