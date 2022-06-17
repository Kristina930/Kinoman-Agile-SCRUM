<svg class="icon_must_see_{{$id}}"
     onclick="addDelFilmInFavorites(event, 3, {{$id}})"
     width="20" height="30" viewBox="0 0 30 40" xmlns="http://www.w3.org/2000/svg"
     @if ($isSelected) style="fill: #f3f3f3" @endif>
    <path
        d="M30 3.75V40L15 31.25L0 40V3.75C0 1.67969 1.67969 0 3.75 0H26.25C28.3203 0 30 1.67969 30 3.75Z"
        fill-opacity="0.6"/>
</svg>
