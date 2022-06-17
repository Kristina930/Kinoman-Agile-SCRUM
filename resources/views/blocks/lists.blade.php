<main class="content">
    <ul>
        <li class="main_catalog">
            @forelse($data as $key => $collection)
                @if($show_list)
                    <a href="{{route($route, $collection[0]->collection_id)}}" class="catalog_link">
                        <h2 class="h2-km catalog_link">{{$key}}</h2>
                    </a>
                @else
                    <h2 class="h2-km catalog_link">{{$key}}</h2>
                @endif
                <div class="grid main_catalog_section" id="{{'list_id_'.$collection[0]->collection_id}}">
                    @include('blocks.cards', ['data' => $collection])
                </div>
                <div class="collection-interval"></div>
            @empty
            @endforelse
        </li>
    </ul>
</main>
