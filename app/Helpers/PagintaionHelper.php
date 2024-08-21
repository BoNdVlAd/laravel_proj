<?php

namespace App\Helpers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class PagintaionHelper
{
    /**
     * @param Collection $results
     * @param $showPerPage
     * @param $queryParams
     * @return array
     */
    public static function paginate(Collection $results, $showPerPage, $queryParams): array
    {
        $pageNumber = Paginator::resolveCurrentPage('page');
        $total = $results->count();
        $items = self::filter($results->forPage($pageNumber, $showPerPage), $queryParams);

        $pagination = [
            'total' => $total,
            'perPage' => intval($showPerPage),
            'currentPage' => $pageNumber,
            'lastPage' => ceil($total / $showPerPage),
            'from' => ($pageNumber - 1) * $showPerPage + 1,
            'to' => min($pageNumber * $showPerPage, $total),
        ];

        return [
            'data' => $items,
            'pagination' => $pagination,
        ];
    }

    /**
     * @param $items
     * @param $queryParams
     * @return array
     */
    public static function filter($items, $queryParams): array
    {
        $sortField = $queryParams['sortField'] ?? 'id';
        $sortBy    = $queryParams['sortBy'] ?? 'ASC';

        return $items->sortBy(function ($item) use ($sortField) {
            return $item->$sortField;
        }, SORT_REGULAR, strtolower($sortBy) === "desc")->values()->all();
    }
}
