<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index(): Factory|View|Application
    {
        if (Auth::check()) {
            $user = Auth::user();
            return $this->getProfile($user, 'profile');
        } else {
            return view('auth.login');
        }
    }

    /** @noinspection SqlResolve */
    public function getProfile($user, $view): Factory|View|Application
    {
        if (Auth::check()) {
            $current_user = Auth::user();
            $cur_id = $current_user->id;

            $result = DB::select(
                'SELECT
                    ul.list_id AS collection_id,
                    l.name,
                    f.*,
                    IFNULL(ul1.list_id, 0) AS is_chosen,
                    IFNULL(ul2.list_id, 0) AS is_favorite,
                    IFNULL(ul3.list_id, 0) AS is_must_see
                FROM user_list_films ul
                LEFT JOIN lists l ON ul.list_id = l.id
                LEFT JOIN films f ON ul.film_id = f.id
                LEFT JOIN user_list_films ul1 ON ul.film_id = ul1.film_id
                    AND ul1.user_id = :current_user1
                    AND ul1.list_id = 1
                LEFT JOIN user_list_films ul2 ON ul.film_id = ul2.film_id
                    AND ul2.user_id = :current_user2
                    AND ul2.list_id = 2
                LEFT JOIN user_list_films ul3 ON ul.film_id = ul3.film_id
                    AND ul3.user_id = :current_user3
                    AND ul3.list_id = 3
                WHERE ul.user_id = :id
                ORDER BY l.id, f.release_year DESC', [
                    'id' => $user->id,
                    'current_user1' => $cur_id,
                    'current_user2' => $cur_id,
                    'current_user3' => $cur_id,
                ]
            );
        } else {
            $result = DB::select(
                'SELECT
                    ul.list_id AS collection_id,
                    l.name,
                    f.*,
                    0 AS is_chosen,
                    0 AS is_favorite,
                    0 AS is_must_see
                FROM user_list_films ul
                LEFT JOIN lists l ON ul.list_id = l.id
                LEFT JOIN films f ON ul.film_id = f.id
                WHERE ul.user_id = :id
                ORDER BY l.id, f.release_year DESC', [
                    'id' => $user->id,
                ]
            );
        }

        $arr = [];
        foreach ($result as $row) {
            $arr[$row->name][] = $row;
        }

        $public_address = '';
        if (!empty($user->public_address)) {
            $public_address = route('profile_public', ['id' => $user->public_address]);
        }

        return view($view, [
            'data' => $arr,
            'user' => $user,
            'route' => 'profile_list',
            'public_address' => $public_address,
        ]);
    }

    public function list(int $list_id): Factory|View|Application
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;
            $list1_id = 1;
            $list2_id = 2;
            $list3_id = 3;

            $query = DB::table('user_list_films as ul')
                ->join('lists as l', 'ul.list_id', '=', 'l.id')
                ->join('films as f', 'ul.film_id', '=', 'f.id')
                ->select('ul.list_id as collection_id', 'l.name', 'f.*');

            $query = $query
                ->selectRaw('IFNULL(ul1.list_id, 0) AS is_chosen')
                ->leftJoin('user_list_films as ul1', function ($leftJoin) use ($user_id, $list1_id) {
                    $leftJoin->on('ul.film_id', '=', 'ul1.film_id')
                        ->where('ul1.user_id', '=', $user_id)
                        ->where('ul1.list_id', '=', $list1_id);
                });
            $query = $query
                ->selectRaw('IFNULL(ul2.list_id, 0) AS is_favorite')
                ->leftJoin('user_list_films as ul2', function ($leftJoin) use ($user_id, $list2_id) {
                    $leftJoin->on('ul.film_id', '=', 'ul2.film_id')
                        ->where('ul2.user_id', '=', $user_id)
                        ->where('ul2.list_id', '=', $list2_id);
                });
            $query = $query
                ->selectRaw('IFNULL(ul3.list_id, 0) AS is_must_see')
                ->leftJoin('user_list_films as ul3', function ($leftJoin) use ($user_id, $list3_id) {
                    $leftJoin->on('ul.film_id', '=', 'ul3.film_id')
                        ->where('ul3.user_id', '=', $user_id)
                        ->where('ul3.list_id', '=', $list3_id);
                });

            $result = $query
                ->where([['ul.user_id', '=', $user_id], ['ul.list_id', '=', $list_id]])
                ->orderBy('ul.list_id')
                ->orderBy('release_year', 'DESC')
                ->paginate(8);

            $arr = [];
            foreach ($result as $row) {
                $arr[$row->name][] = $row;
            }

            return view('profile_list', [
                'data' => $arr,
                'user' => $user,
                'pagination' => $result,
                'route' => 'profile_list',
                'show_list' => true,
            ]);
        } else {
            return view('auth.login');
        }
    }

    public function moveFilmFromListToList(Request $request): int
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $new_list_id = $request->new_list_id;
            $film_id = $request->film_id;
            $old_list_id = $request->old_list_id;

            DB::table('user_list_films')
                ->where('user_id', $user_id)
                ->where('film_id', $film_id)
                ->where('list_id', $old_list_id)
                ->delete();

            DB::table('user_list_films')
                ->insertOrIgnore(
                    ['user_id' => $user_id, 'film_id' => $film_id, 'list_id' => $new_list_id]
                );

            return $new_list_id;
        } else {
            return 0;
        }
    }

    public function edit(): Factory|View|Application
    {
        if (Auth::check()) {
            $user = Auth::user();

            return view('profile_edit', [
                'user' => $user,
            ]);
        } else {
            return view('auth.login');
        }
    }

    public function update(Request $request): View|Factory|Redirector|RedirectResponse|Application
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;

            $public_address = $user->public_address;
            if (empty($public_address)) {
                $public_address = rand();
            }

            $params = $request->all();
            $show_public = !empty($params['show_public']);

            DB::table('users')
                ->where('id', $user_id)
                ->update([
                    'email' => $request->email,
                    'name' => $request->name,
                    'show_public' => $show_public,
                    'public_address' => $public_address,
                ]);

            return redirect('profile');
        } else {
            return view('auth.login');
        }
    }

    public function public(int $id): Factory|View|Application
    {
        $query = DB::table('users')
            ->where('public_address', $id)
            ->where('show_public', 1);

        $user = $query->first();

        if ($user) {
            return $this->getProfile($user, 'profile_public');
        } else {
            return view('auth.login');
        }
    }

    public function uploadUserImage(Request $request): Redirector|Application|RedirectResponse
    {
        // Проверка
        $this->validate($request, [
            'user_image' => 'image|nullable|max:2048',
        ]);

        // Если есть файл
        if ($request->hasFile('user_image')) {
            // Имя и расширение файла
            $filenameWithExt = $request->file('user_image')->getClientOriginalName();
            // Оригинальное имя файла
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Расширение
            $extension = $request->file('user_image')->getClientOriginalExtension();
            // Путь для сохранения
            $fileNameToStore = "user_images/" . $filename . "_" . time() . "." . $extension;
            // Сохраняем файл
            $path = $request->file('user_image')->storeAs('public/', $fileNameToStore);

            if (Auth::check()) {
                $user = Auth::user();
                $user_id = $user->id;

                DB::table('users')
                    ->where('id', $user_id)
                    ->update([
                        'image_path' => 'storage/' . $fileNameToStore,
                    ]);
            }
        }

        return redirect('profile_edit');
    }
}
