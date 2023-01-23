<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait HasPageChecker
{
    /*
     * When deleting a post, you should not go to the beginning
     * the list of posts, as usual, but stay on the same page.
     * But, in this case, we need to solve the problem of
     * one entity on the last page.
     *
     * @param Paginator $paginator
     * @return int Page number
    */
    public static function getCurrentPageAfterDeletion(LengthAwarePaginator $paginator): int
    {
        $page = $paginator->currentPage();
        // if we are on the last page and
        // there is only one entity on the last page
        if ($paginator->lastPage() == $paginator->currentPage() && 
          (($paginator->total() % $paginator->perPage()) == 1)
        ) {
          // the number of page must decrease by 1
          $page--;
        }
        
        return $page;
    }
}
