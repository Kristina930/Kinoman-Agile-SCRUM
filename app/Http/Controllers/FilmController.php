<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    public function film(Film $film): Factory|View|Application
    {
        $film_id = $film->getKey('id');
        $lists = $this->getLists($film_id);
        $emojis = $this->getEmojis($film_id);
        $rating = $this->getRating($film_id);
        $tags = $this->getTags($film_id);

        return view('film', [
            'data' => $film,
            'lists' => $lists,
            'emojis' => $emojis,
            'rating' => $rating,
            'tags' => $tags,
        ]);
    }

    /** @noinspection SqlResolve */
    public function getLists(int $film_id): array
    {
        $lists = [];

        if (Auth::check()) {
            $user_id = Auth::id();

            $lists = DB::select(
                'SELECT
                    l.*,
                    IFNULL(list_id, 0) AS list_id,
                    :cur_user_id AS user_id,
                    :cur_film_id AS film_id
                FROM lists l
                LEFT JOIN user_list_films ul ON id = list_id
                                               AND user_id = :user_id
                                               AND film_id = :film_id
                ORDER BY l.id', [
                    'user_id' => $user_id,
                    'cur_user_id' => $user_id,
                    'film_id' => $film_id,
                    'cur_film_id' => $film_id]
            );
        }

        return $lists;
    }

    /** @noinspection SqlResolve */
    public function getEmojis(int $film_id): array
    {
        if (Auth::check()) {
            $user_id = Auth::id();

            $emojis = DB::select(
                'SELECT
                    f.id,
                    IFNULL(ufe1.emoji_id, 0) AS is_good,
                    IFNULL(ufe2.emoji_id, 0) AS is_dull,
                    IFNULL(ufe3.emoji_id, 0) AS is_scary,
                    IFNULL(ufe4.emoji_id, 0) AS is_sad,
                    IFNULL(ufe5.emoji_id, 0) AS is_fun,
                    SUM(CASE WHEN fe.emoji_id = 1 THEN 1 ELSE 0 END) AS count_good,
                    SUM(CASE WHEN fe.emoji_id = 2 THEN 1 ELSE 0 END) AS count_dull,
                    SUM(CASE WHEN fe.emoji_id = 3 THEN 1 ELSE 0 END) AS count_scary,
                    SUM(CASE WHEN fe.emoji_id = 4 THEN 1 ELSE 0 END) AS count_sad,
                    SUM(CASE WHEN fe.emoji_id = 5 THEN 1 ELSE 0 END) AS count_fun
                FROM films f
                LEFT JOIN user_film_emojis ufe1 ON f.id = ufe1.film_id AND ufe1.user_id = :user_id1 AND ufe1.emoji_id = 1
                LEFT JOIN user_film_emojis ufe2 ON f.id = ufe2.film_id AND ufe2.user_id = :user_id2 AND ufe2.emoji_id = 2
                LEFT JOIN user_film_emojis ufe3 ON f.id = ufe3.film_id AND ufe3.user_id = :user_id3 AND ufe3.emoji_id = 3
                LEFT JOIN user_film_emojis ufe4 ON f.id = ufe4.film_id AND ufe4.user_id = :user_id4 AND ufe4.emoji_id = 4
                LEFT JOIN user_film_emojis ufe5 ON f.id = ufe5.film_id AND ufe5.user_id = :user_id5 AND ufe5.emoji_id = 5
                LEFT JOIN user_film_emojis fe ON f.id = fe.film_id
                WHERE f.id = :film_id
                GROUP BY f.id', [
                    'user_id1' => $user_id,
                    'user_id2' => $user_id,
                    'user_id3' => $user_id,
                    'user_id4' => $user_id,
                    'user_id5' => $user_id,
                    'film_id' => $film_id
                ]
            );
        } else {
            $emojis = DB::select(
                'SELECT
                    f.id,
                    0 AS is_good,
                    0 AS is_dull,
                    0 AS is_scary,
                    0 AS is_sad,
                    0 AS is_fun,
                    SUM(CASE WHEN fe.emoji_id = 1 THEN 1 ELSE 0 END) AS count_good,
                    SUM(CASE WHEN fe.emoji_id = 2 THEN 1 ELSE 0 END) AS count_dull,
                    SUM(CASE WHEN fe.emoji_id = 3 THEN 1 ELSE 0 END) AS count_scary,
                    SUM(CASE WHEN fe.emoji_id = 4 THEN 1 ELSE 0 END) AS count_sad,
                    SUM(CASE WHEN fe.emoji_id = 5 THEN 1 ELSE 0 END) AS count_fun
                FROM films f
                LEFT JOIN user_film_emojis fe ON f.id = fe.film_id
                WHERE f.id = :film_id
                GROUP BY f.id', ['film_id' => $film_id]
            );
        }

        return $emojis;
    }

    /** @noinspection SqlResolve */
    public function getRating(int $film_id): array
    {
        if (Auth::check()) {
            $user_id = Auth::id();

            $rating = DB::select(
                'SELECT
                IFNULL(ufr.rating, 0) AS rating
            FROM
                films f
            LEFT JOIN user_film_ratings ufr ON f.id = ufr.film_id AND ufr.user_id = :user_id
            WHERE f.id = :film_id', [
                'user_id' => $user_id,
                'film_id' => $film_id,
            ]);
        } else {
            $rating = DB::select('SELECT 0 AS rating');
        }

        return $rating;
    }

    /** @noinspection SqlResolve */
    public function getTags(int $film_id): array
    {
        if (Auth::check()) {
            $user_id = Auth::id();

            $tags = DB::select(
                'SELECT
                    t.*,
                    IFNULL(uft.tag_id, 0) AS is_selected,
                    SUM(CASE WHEN uf.tag_id = t.id THEN 1 ELSE 0 END) AS count
                FROM tags t
                LEFT JOIN user_film_tags uft ON t.id = uft.tag_id AND uft.user_id = :user_id AND uft.film_id = :film_id
                LEFT JOIN user_film_tags uf ON uf.film_id = :film_id1
                GROUP BY t.id
                ORDER BY t.id', [
                    'user_id' => $user_id,
                    'film_id' => $film_id,
                    'film_id1' => $film_id,
                ]
            );
        } else {
            $tags = DB::select(
                'SELECT
                    t.*,
                    0 AS is_selected,
                    SUM(CASE WHEN uf.tag_id = t.id THEN 1 ELSE 0 END) AS count
                FROM tags t
                LEFT JOIN user_film_tags uf ON uf.film_id = :film_id
                GROUP BY t.id
                ORDER BY t.id', [
                    'film_id' => $film_id,
                ]
            );
        }

        return $tags;
    }

    public function addDelFilmInList(Request $request): Factory|View|Application
    {
        $user_id = $request->user_id;
        $film_id = $request->film_id;
        $list_id = $request->list_id;
        $new_list_id = $request->new_list_id;

        if ($list_id) {
            DB::table('user_list_films')
                ->where('user_id', $user_id)
                ->where('film_id', $film_id)
                ->where('list_id', $list_id)
                ->delete();
        } else {
            DB::table('user_list_films')
                ->insertOrIgnore(
                    ['user_id' => $user_id, 'film_id' => $film_id, 'list_id' => $new_list_id]
                );
        }

        $lists = $this->getLists($film_id);

        return view('blocks.film_lists', ['lists' => $lists]);
    }

    public function addDelFilmInFavorites(Request $request): View|Factory|int|Application
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $film_id = $request->film_id;
            $list_id = $request->list_id;
            $isSelected = false;
            $view = 'blocks.icon_chosen';

            if ($list_id == 2) {
                $view = 'blocks.icon_favorite';
            } else if ($list_id == 3) {
                $view = 'blocks.icon_must_see';
            }

            $query = DB::table('user_list_films')
                ->where('user_id', $user_id)
                ->where('film_id', $film_id)
                ->where('list_id', $list_id);

            $record = $query->first();

            if ($record) {
                $query->delete();
            } else {
                DB::table('user_list_films')
                    ->insertOrIgnore(
                        ['user_id' => $user_id, 'film_id' => $film_id, 'list_id' => $list_id]
                    );
                $isSelected = true;
            }

            return view($view, [
                'id' => $film_id,
                'isSelected' => $isSelected
            ]);
        } else {
            return 0;
        }
    }

    public function addDelEmoji(Request $request): View|Factory|int|Application
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $film_id = $request->film_id;
            $emoji_id = $request->emoji_id;
            $count = (int)$request->count;
            $isSelected = false;
            $view = 'blocks.emoji_good';

            if ($emoji_id == 2) {
                $view = 'blocks.emoji_dull';
            } else if ($emoji_id == 3) {
                $view = 'blocks.emoji_scary';
            } else if ($emoji_id == 4) {
                $view = 'blocks.emoji_sad';
            } else if ($emoji_id == 5) {
                $view = 'blocks.emoji_fun';
            }

            $query = DB::table('user_film_emojis')
                ->where('user_id', $user_id)
                ->where('film_id', $film_id)
                ->where('emoji_id', $emoji_id);

            $record = $query->first();

            if ($record) {
                $query->delete();
                $count--;
            } else {
                DB::table('user_film_emojis')
                    ->insertOrIgnore(
                        ['user_id' => $user_id, 'film_id' => $film_id, 'emoji_id' => $emoji_id]
                    );
                $isSelected = true;
                $count++;
            }

            return view($view, [
                'id' => $film_id,
                'isSelected' => $isSelected,
                'count' => $count,
            ]);
        } else {
            return 0;
        }
    }

    public function rateFilm(Request $request): View|Factory|int|Application
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $film_id = $request->film_id;
            $rating = $request->rating;

            $query = DB::table('user_film_ratings')
                ->where('user_id', $user_id)
                ->where('film_id', $film_id)
                ->where('rating', $rating);

            $record = $query->first();

            if ($record) {
                $query->delete();
                $rating = 0;
            } else {
                $query = DB::table('user_film_ratings')
                    ->where('user_id', $user_id)
                    ->where('film_id', $film_id);

                $record = $query->first();

                if ($record) {
                    $query->delete();
                }

                DB::table('user_film_ratings')
                    ->insert(
                        ['user_id' => $user_id, 'film_id' => $film_id, 'rating' => $rating]
                    );
            }

            $this->updateRating($film_id);

            return view('blocks.rating_numbers', [
                'id' => $film_id,
                'rating' => $rating,
            ]);
        } else {
            return 0;
        }
    }

    /** @noinspection SqlResolve */
    public function updateRating(int $film_id)
    {
        $result = DB::select(
            'SELECT
                IFNULL(avg(ufr.rating), 0) AS rating
            FROM
                user_film_ratings ufr
            WHERE ufr.film_id = :film_id', ['film_id' => $film_id]
        );

        $rating = $result[0]->rating;

        DB::table('films')
            ->where('id', $film_id)
            ->update(
                ['rating' => $rating]
            );
    }

    public function addDelTag(Request $request): View|Factory|int|Application
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $film_id = $request->film_id;
            $tag_id = $request->tag_id;
            $name = $request->name;
            $count = (int)$request->count;
            $isSelected = false;

            $query = DB::table('user_film_tags')
                ->where('user_id', $user_id)
                ->where('film_id', $film_id)
                ->where('tag_id', $tag_id);

            $record = $query->first();

            if ($record) {
                $query->delete();
                $count--;
            } else {
                DB::table('user_film_tags')
                    ->insertOrIgnore(
                        ['user_id' => $user_id, 'film_id' => $film_id, 'tag_id' => $tag_id]
                    );
                $isSelected = true;
                $count++;
            }

            return view('blocks.tag', [
                'id' => $film_id,
                'tag_id' => $tag_id,
                'name' => $name,
                'count' => $count,
                'is_selected' => $isSelected,
            ]);
        } else {
            return 0;
        }
    }

}
