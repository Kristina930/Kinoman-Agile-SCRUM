@forelse($data as $item)
    @include('blocks.card', ['item' => $item])
@empty
@endforelse
