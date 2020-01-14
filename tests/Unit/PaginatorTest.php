<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit;

use Harentius\BlogBundle\Paginator;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class PaginatorTest extends TestCase
{
    public function testPaginatePagePassFromRequest(): void
    {
        /** @var PaginatorInterface|MockObject $knpPaginator */
        $knpPaginator = $this->createKnpPaginatorMock();
        $knpPaginator
            ->expects($this->once())
            ->method('paginate')
            ->with([], 3)
        ;

        $paginator = $this->createPaginator($knpPaginator);
        $request = new Request();
        $request->query->set('page', 3);

        $paginator->paginate($request, []);
    }

    public function testPaginatePerPage(): void
    {
        /** @var PaginatorInterface|MockObject $knpPaginator */
        $knpPaginator = $this->createKnpPaginatorMock();
        $knpPaginator
            ->expects($this->once())
            ->method('paginate')
            ->with([], 1, 10)
        ;

        $paginator = $this->createPaginator($knpPaginator);
        $request = new Request();

        $paginator->paginate($request, [], [], 10);
    }

    public function testPaginateDefaultPerPage(): void
    {
        /** @var PaginatorInterface|MockObject $knpPaginator */
        $knpPaginator = $this->createKnpPaginatorMock();
        $knpPaginator
            ->expects($this->once())
            ->method('paginate')
            ->with([], 1, 123)
        ;

        $paginator = $this->createPaginator($knpPaginator);
        $request = new Request();

        $paginator->paginate($request, []);
    }

    private function createPaginator(PaginatorInterface $knpPaginator): Paginator
    {
        return new Paginator($knpPaginator, 123);
    }

    private function createKnpPaginatorMock(): PaginatorInterface
    {
        $knpPaginator = $this->createMock(PaginatorInterface::class);
        $knpPaginator
            ->method('paginate')
            ->willReturn(new SlidingPagination([]))
        ;

        return $knpPaginator;
    }
}
