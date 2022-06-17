<a href="{{route('film', $item->id)}}" draggable="true" class="main_catalog_link" id="film_id_{{$item->id}}"
   data-list_id="{{$item->collection_id}}">
    <img src="{{'../img/'.$item->image_path}}" alt="{{$item->rus_title}}" class="main_catalog_img"/>
    <div class="flex sp_btw main_catalog_description">
        <div>
            @auth
                @include('blocks.icon_chosen', ['id' => $item->id, 'isSelected' => $item->is_chosen])
                @include('blocks.icon_favorite', ['id' => $item->id, 'isSelected' => $item->is_favorite])
                @include('blocks.icon_must_see', ['id' => $item->id, 'isSelected' => $item->is_must_see])
            @endauth
        </div>
        <div class="rating_catalog">
            <p class="main_catalog_description_h3">Рейтинг: {{$item->rating}} {{$item->release_year}}</p>
            <p> {{$item->rus_title}}
                — {{$item->briefly}}
            </p>
        </div>
    </div>
</a>
