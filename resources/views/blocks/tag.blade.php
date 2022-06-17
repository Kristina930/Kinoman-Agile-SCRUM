<div @auth
     id="tag_{{ $tag_id }}" onclick="addDelTag({{$id}}, {{ $tag_id }}, {{$count}}, '{{$name}}')"
    @endauth class="hashtag_grid">
    <span class="movie_blocks_hashtag_span"
          @if ($is_selected) style="background-color: #8C8493; color: #f3f3f3; border-radius: 12px;
    padding: 3px 4px;}" @endif
    >#{{$name}}</span>
    <span class="movie_blocks_hashtag_span hashtag_span_number">{{$count}}</span>
</div>
