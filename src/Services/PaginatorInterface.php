<?php


namespace App\Services;


use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

interface PaginatorInterface
{
    /**
     * @param $query
     * @param Request $request
     * @param int $limit
     * @return Paginator
     */
    public function paginate($query, Request $request, int $limit): Paginator;

    /**
     * @param Request $request
     * @return int
     */
    public function currentPage(Request $request): int;

    /**
     * @param Paginator $paginator
     * @return int
     */
    public function lastPage(Paginator $paginator): int;

    /**
     * @param Paginator $paginator
     * @param Request $request
     * @return int
     */
    public function nextPage(Paginator $paginator, Request $request): int;

    /**
     * @param Paginator $paginator
     * @param Request $request
     * @return int
     */
    public function previousPage(Paginator $paginator, Request $request): int;

    /**
     * @param Paginator $paginator
     * @return int
     */
    public function total(Paginator $paginator): int;
}
