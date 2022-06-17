@auth
    @forelse($lists as $list)
        <div class="movie_drop_a"
             onclick="addDelFilmInList(
             {{$list->user_id}},
             {{$list->film_id}},
             {{$list->list_id}},
             {{$list->id}})"
             @if ($list->list_id)
             style="background: lightgray"
{{--             style="border-bottom: solid"--}}
             @else
{{--             style="background: white"--}}
            @endif
        >
            {{$list->name}}
        </div>
    @empty
    @endforelse
@endauth
