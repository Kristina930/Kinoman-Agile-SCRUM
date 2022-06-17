<div id="rating_numbers">
    @for ($i = 1; $i <= 10; $i++)
        <span class="movie_rating_number_span" onclick="rateFilm(event, {{ $id }}, {{ $i }})"
              @if ($i == $rating) style="background-color: #8C8493; color: #f3f3f3;" @endif>
        {{ $i }}
    </span>
    @endfor
</div>
