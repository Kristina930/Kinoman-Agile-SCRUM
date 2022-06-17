<div class="grid main_catalog_section" id="list_id_0">
    @forelse($data as $item)
        @include('blocks.card', ['item' => $item])
    @empty
    @endforelse
</div>
