<div class="box_grid">
    @forelse($tags as $tag)
        @include('blocks.tag',  [
        'id' => $id,
        'tag_id' => $tag->id,
        'name' => $tag->name,
        'count' => $tag->count,
        'is_selected' => $tag->is_selected
        ])
    @empty
    @endforelse
</div>
