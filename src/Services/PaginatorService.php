<?php


namespace App\Services;


use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;


class PaginatorService implements PaginatorInterface
{
    /**
     * @param QueryBuilder|Query $query
     * @param Request $request
     * @param int $limit
     * @return Paginator
     */
    public function paginate($query, Request $request, int $limit): Paginator
    {
        $currentPage = $this->currentPage($request);
        $paginator = new Paginator($query);
        $paginator
            ->getQuery()
            ->setFirstResult($limit * ($currentPage - 1))
            ->setMaxResults($limit);

        return $paginator;
    }

    /**
     * @param Request $request
     * @return int
     */
    public function currentPage(Request $request): int
    {
        return $request->query->getInt('page') ?: 1;
    }

    /**
     * @param Paginator $paginator
     * @return int
     */
    public function lastPage(Paginator $paginator): int
    {
        return ceil($paginator->count() / $paginator->getQuery()->getMaxResults());
    }

    /**
     * @param Paginator $paginator
     * @param Request $request
     * @return int
     */
    public function nextPage(Paginator $paginator, Request $request): int
    {
        $nextPage = $this->currentPage($request) + 1;
        $lastPage = $this->lastPage($paginator);
        if ($nextPage <= $lastPage) {
            return $nextPage;
        }

        return $lastPage;
    }

    /**
     * @param Paginator $paginator
     * @param Request $request
     * @return int
     */
    public function previousPage(Paginator $paginator, Request $request): int
    {
        $previousPage = $this->currentPage($request) - 1;
        if ($previousPage >= 0) {
            return $previousPage;
        }

        return 1;
    }

    /**
     * @param Paginator $paginator
     * @return int
     */
    public function total(Paginator $paginator): int
    {
        return $paginator->count();
    }
}
