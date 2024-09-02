<?php

namespace App\Helpers;

use Illuminate\Pagination\Paginator;

class PagintaionHelper
{
    /**
     * @param $results
     * @param $showPerPage
     * @param $queryParams
     * @return array
     */
    public static function paginate($results, $showPerPage, $queryParams): array
    {
        $pageNumber = Paginator::resolveCurrentPage('page') ?: 1;
        $total = count(self::filter($results, $queryParams));

        $items = self::filter($results->forPage($pageNumber, $showPerPage), $queryParams);

        $lastPage = ceil($total / $showPerPage);

        if ($pageNumber > $lastPage) {
            $pageNumber = $lastPage;
        }

        $pagination = [
            'total' => $total,
            'perPage' => intval($showPerPage),
            'currentPage' => $pageNumber,
            'lastPage' => $lastPage,
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



        foreach ($queryParams as $key => $value) {
            if ($key !== 'page' && $key !== 'perPage' && $key !== 'sortField' && $key !== 'sortBy') {
                $items = $items->where($key, 'LIKE', "%{$value}%");
            }
        }
        $items = $items->get();

        return $items->sortBy(function ($item) use ($sortField) {
            return $item->$sortField;
        }, SORT_REGULAR, strtolower($sortBy) === "desc")->values()->all();
    }
}
