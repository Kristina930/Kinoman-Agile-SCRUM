<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    /** @noinspection SqlResolve */
    public function index(): Factory|View|Application
    {
        if (Auth::check()) {
            $user_id = Auth::id();

            $result = DB::select(
                'SELECT
                fc.collection_id,
                c.name,
                f.*,
                IFNULL(ul1.list_id, 0) AS is_chosen,
                IFNULL(ul2.list_id, 0) AS is_favorite,
                IFNULL(ul3.list_id, 0) AS is_must_see
            FROM film_collections fc
            LEFT JOIN films f ON fc.film_id = f.id
            LEFT JOIN collections c ON fc.collection_id = c.id
            LEFT JOIN user_list_films ul1 ON fc.film_id = ul1.film_id
                AND ul1.user_id = :user_id1
                AND ul1.list_id = 1
            LEFT JOIN user_list_films ul2 ON fc.film_id = ul2.film_id
                AND ul2.user_id = :user_id2
                AND ul2.list_id = 2
            LEFT JOIN user_list_films ul3 ON fc.film_id = ul3.film_id
                AND ul3.user_id = :user_id3
                AND ul3.list_id = 3
            ORDER BY fc.collection_id, f.release_year DESC',
                [
                    'user_id1' => $user_id,
                    'user_id2' => $user_id,
                    'user_id3' => $user_id,
                ]
            );
        } else {
            $result = DB::select(
                'SELECT
                fc.collection_id,
                c.name,
                f.*
            FROM film_collections fc
            LEFT JOIN films f ON fc.film_id = f.id
            LEFT JOIN collections c ON fc.collection_id = c.id
            ORDER BY fc.collection_id, f.release_year DESC'
            );
        }

        $arr = [];
        foreach ($result as $row) {
            $arr[$row->name][] = $row;
        }

        return view('collections', [
            'data' => $arr,
            'route' => 'collection'
        ]);
    }

    public function collection(int $id): Factory|View|Application
    {
        $query = DB::table('film_collections as fc')
            ->join('films as f', 'fc.film_id', '=', 'f.id')
            ->join('collections as c', 'fc.collection_id', '=', 'c.id')
            ->select('fc.collection_id', 'c.name', 'f.*');

        if (Auth::check()) {
            $user_id = Auth::id();
            $list1_id = 1;
            $list2_id = 2;
            $list3_id = 3;

            $query = $query
                ->selectRaw('IFNULL(ul1.list_id, 0) AS is_chosen')
                ->leftJoin('user_list_films as ul1', function ($leftJoin) use ($user_id, $list1_id) {
                    $leftJoin->on('fc.film_id', '=', 'ul1.film_id')
                        ->where('ul1.user_id', '=', $user_id)
                        ->where('ul1.list_id', '=', $list1_id);
                });
            $query = $query
                ->selectRaw('IFNULL(ul2.list_id, 0) AS is_favorite')
                ->leftJoin('user_list_films as ul2', function ($leftJoin) use ($user_id, $list2_id) {
                    $leftJoin->on('fc.film_id', '=', 'ul2.film_id')
                        ->where('ul2.user_id', '=', $user_id)
                        ->where('ul2.list_id', '=', $list2_id);
                });
            $query = $query
                ->selectRaw('IFNULL(ul3.list_id, 0) AS is_must_see')
                ->leftJoin('user_list_films as ul3', function ($leftJoin) use ($user_id, $list3_id) {
                    $leftJoin->on('fc.film_id', '=', 'ul3.film_id')
                        ->where('ul3.user_id', '=', $user_id)
                        ->where('ul3.list_id', '=', $list3_id);
                });
        }

        $result = $query
            ->where([['fc.collection_id', '=', $id]])
            ->orderBy('collection_id')
            ->orderBy('release_year', 'DESC')
            ->paginate(8);

        $arr = [];
        foreach ($result->items() as $row) {
            $arr[$row->name][] = $row;
        }

        return view('collection', [
            'data' => $arr,
            'pagination' => $result,
            'route' => 'collection'
        ]);
    }
}
