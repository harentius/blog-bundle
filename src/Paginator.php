<?php

declare(strict_types=1);

namespace Harentius\BlogBundle;

use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Pagination\AbstractPagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class Paginator
{
    public function __construct(private readonly PaginatorInterface $paginator, private int $defaultPerPage)
    {
    }

    /**
     * @return SlidingPagination
     */
    public function paginate(Request $request, mixed $target, array $options = [], ?int $perPage = null): AbstractPagination
    {
        if ($perPage === null) {
            $perPage = $this->defaultPerPage;
        }

        $page = max(1, (int) $request->query->get($options['pageParameterName'] ?? 'page', 1));
        /** @var AbstractPagination $pagination */
        $pagination = $this->paginator->paginate($target, $page, $perPage, $options);

        return $pagination;
    }
}
