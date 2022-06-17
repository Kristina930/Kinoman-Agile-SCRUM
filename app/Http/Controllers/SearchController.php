<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(): Factory|View|Application
    {
        $data = [];
        $genres = Genre::all();

        $actors = DB::table('persons')
            ->distinct()
            ->select('id', 'firstname', 'lastname')
            ->leftJoin('film_persons', 'id', '=', 'person_id')
            ->where('position_id', '<', 5)
            ->orderBy('lastname')
            ->get();

        $years[] = ['id' => 2020, 'name' => '2020-2022'];
        for ($i = 2010; $i >= 1900; $i -= 10) {
            $lastYear = $i + 9;
            $years[] = ['id' => $i, 'name' => "$i-$lastYear"];
        }

        return view('search', [
            'data' => $data,
            'genres' => $genres,
            'actors' => $actors,
            'years' => $years,
        ]);
    }

    public function filter(Request $request): Factory|View|Application
    {
        $params = $request->all();
        $searchString = $params['searchString'];
        $genreStr = 'genre_id_';
        $genres = [];
        $actorStr = 'actor_id_';
        $actors = [];
        $yearStr = 'year_id_';
        $years = [];
        $result = [];

        foreach ($params as $key => $value) {
            if (str_contains($key, $genreStr)) {
                $genres[] = str_replace($genreStr, '', $key);
            }
            if (str_contains($key, $actorStr)) {
                $actors[] = str_replace($actorStr, '', $key);
            }
            if (str_contains($key, $yearStr)) {
                $startYear = str_replace($yearStr, '', $key);
                $years = array_merge($years, range($startYear, $startYear + 9));
            }
        }

        if (!empty($searchString) || !empty($genres) || !empty($actors) || !empty($years)) {
            $query = DB::table('films as f')
                ->distinct()
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

            if (!empty($genres)) {
                $query = $query->leftJoin('film_genres as fg', 'f.id', '=', 'fg.film_id');
            }

            if (!empty($actors)) {
                $query = $query->leftJoin('film_persons as fp', 'f.id', '=', 'fp.film_id');
            }

            if (!empty($searchString)) {
                $str = "%$searchString%";
                $query = $query->where(function ($query) use ($str) {
                    $query->where('title', 'like', $str);
                    $query->orWhere('rus_title', 'like', $str);
                });
            }

            if (!empty($genres)) {
                $query = $query->where(function ($query) use ($genres) {
                    $query->whereIn('fg.genre_id', $genres);
                });
            }

            if (!empty($actors)) {
                $query = $query->where(function ($query) use ($actors) {
                    $query->whereIn('fp.person_id', $actors);
                    $query->where('fp.position_id', '<', 5);
                });
            }

            if (!empty($years)) {
                sort($years);
                $query = $query->where(function ($query) use ($years) {
                    $query->whereIn('release_year', $years);
                });
            }

            $result = $query
                ->orderBy('release_year', 'desc')
                ->get();
        }

        return view('blocks.cards_single', ['data' => $result]);
    }
}
