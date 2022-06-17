<main class="content">
    <div style="position: relative;">
        <div id="load"></div>
        <ul id="test">
            <li class="main_catalog">
                @forelse($data as $key => $collection)
                    <a href="{{route($route, $collection[0]->collection_id)}}" class="catalog_link">
                        <h2 class="h2-km catalog_link">{{$key}}</h2>
                    </a>
                    @include('blocks.collection', ['collection' => $collection])
                    <div class="collection-interval"></div>
                @empty
                @endforelse
            </li>
        </ul>
    </div>
</main>

