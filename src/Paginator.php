<?php

declare(strict_types=1);

namespace Harentius\BlogBundle;

use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Pagination\AbstractPagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class Paginator
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * @var int
     */
    private $postsPerPage;

    /**
     * @param PaginatorInterface $paginator
     * @param int $postsPerPage
     */
    public function __construct(PaginatorInterface $paginator, int $postsPerPage)
    {
        $this->paginator = $paginator;
        $this->postsPerPage = $postsPerPage;
    }

    /**
     * @param Request $request
     * @param mixed $target
     * @param array $options
     * @return SlidingPagination
     */
    public function paginate(Request $request, $target, array $options = []): AbstractPagination
    {
        $page = max(1, (int) $request->query->get($options['pageParameterName'] ?? 'page', 1));
        /** @var AbstractPagination $pagination */
        $pagination = $this->paginator->paginate($target, $page, $this->postsPerPage, $options);

        return $pagination;
    }
}
