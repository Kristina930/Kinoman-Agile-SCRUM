<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function index(): Factory|View|Application
    {
        $query = DB::table('films as f')
            ->select('f.*')
            ->selectRaw('0 as collection_id');

        if (Auth::check()) {
            $user_id = Auth::id();
            $list1_id = 1;
            $list2_id = 2;
            $list3_id = 3;
            $query = $query
                ->selectRaw('IFNULL(ul1.list_id, 0) AS is_chosen')
                ->leftJoin('user_list_films as ul1', function ($leftJoin) use ($user_id, $list1_id) {
                    $leftJoin->on('id', '=', 'ul1.film_id')
                        ->where('ul1.user_id', '=', $user_id)
                        ->where('ul1.list_id', '=', $list1_id);
                });
            $query = $query
                ->selectRaw('IFNULL(ul2.list_id, 0) AS is_favorite')
                ->leftJoin('user_list_films as ul2', function ($leftJoin) use ($user_id, $list2_id) {
                    $leftJoin->on('id', '=', 'ul2.film_id')
                        ->where('ul2.user_id', '=', $user_id)
                        ->where('ul2.list_id', '=', $list2_id);
                });
            $query = $query
                ->selectRaw('IFNULL(ul3.list_id, 0) AS is_must_see')
                ->leftJoin('user_list_films as ul3', function ($leftJoin) use ($user_id, $list3_id) {
                    $leftJoin->on('id', '=', 'ul3.film_id')
                        ->where('ul3.user_id', '=', $user_id)
                        ->where('ul3.list_id', '=', $list3_id);
                });
        }

        $films = $query
            ->orderBy('release_year', 'desc')
            ->orderBy('title', 'asc')
            ->paginate(12);

        return view('catalog', ['data' => $films]);
    }
}
