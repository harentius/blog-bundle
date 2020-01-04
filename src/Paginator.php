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
    private $defaultPerPage;

    /**
     * @param PaginatorInterface $paginator
     * @param int $defaultPerPage
     */
    public function __construct(PaginatorInterface $paginator, int $defaultPerPage)
    {
        $this->paginator = $paginator;
        $this->defaultPerPage = $defaultPerPage;
    }

    /**
     * @param Request $request
     * @param mixed $target
     * @param array $options
     * @param int|null $perPage
     * @return SlidingPagination
     */
    public function paginate(Request $request, $target, array $options = [], ?int $perPage = null): AbstractPagination
    {
        if ($perPage === 0) {
            $perPage = $this->defaultPerPage;
        }

        $page = max(1, (int) $request->query->get($options['pageParameterName'] ?? 'page', 1));
        /** @var AbstractPagination $pagination */
        $pagination = $this->paginator->paginate($target, $page, $perPage, $options);

        return $pagination;
    }
}
