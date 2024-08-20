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
     * @return mixed
     */
    public static function paginate(Collection $results, $showPerPage, $queryParams): array
    {
        $pageNumber = Paginator::resolveCurrentPage('page');

        return self::filter($results->forPage($pageNumber, $showPerPage), $queryParams);
    }

    /**
     * @param $items
     * @param $queryParams
     * @return mixed
     */
    public static function filter($items, $queryParams): array
    {
        $sortField = $queryParams['sortField'] ?? 'id';
        $sortBy    = $queryParams['sortBy'] ?? 'ASC';

        return $items->sortBy(function ($item) use ($sortField) {
            return $item->$sortField;
        }, SORT_REGULAR, $sortBy === "DESC")->values()->all();
    }
}
