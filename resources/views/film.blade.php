@extends('layouts.main')

@section('title')
    @parent Фильм
@endsection

@section('pageName')
    @parent Фильм
@endsection

@section('content')
    <main class="container conteiner_movie wrap">
        <div class="movie_blocks">
            <div class="movie_blocks_text_img">
                <h2 class="movie_blocks_text">{{$data->rus_title}}</h2>
                <p class="movie_blocks_text_svg">
                    {{$data->release_year}} {{$data->genres}} {{$data->length_in_minutes}} мин. 16+
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="15" height="20"
                         class="movie_blocks_thumb_svg">
                        <path d="M192 352c53.03 0 96-42.97 96-96v-160c0-53.03-42.97-96-96-96s-96 42.97-96
                    96v160C96 309 138.1 352 192 352zM344 192C330.7 192 320 202.7 320 215.1V256c0 73.33-61.97
                    132.4-136.3 127.7c-66.08-4.169-119.7-66.59-119.7-132.8L64 215.1C64 202.7 53.25 192 40 192S16 202.7
                    16 215.1v32.15c0 89.66 63.97 169.6 152 181.7V464H128c-18.19 0-32.84 15.18-31.96 33.57C96.43 505.8
                    103.8 512 112 512h160c8.222 0 15.57-6.216 15.96-14.43C288.8 479.2 274.2 464 256 464h-40v-33.77C301.7
                    418.5 368 344.9 368 256V215.1C368 202.7 357.3 192 344 192z"/>
                    </svg>
                    Rus
                </p>
                <p class="movie_blocks_text_p">
                    {{$data->briefly}}
                </p>
                <p class="movie_blocks_text_p">
                    <span class="movie_blocks_text_grey">Режиссёр:</span> {{$data->directors}} <br>
                    <span class="movie_blocks_text_grey">Актёры:</span> {{$data->actors}} <br>
                    <span class="movie_blocks_text_grey">Рейтинг Киномана:</span> <span
                        class="movie_blocks_text_white"> {{$data->rating}} </span><br>
                </p>
                <div>
                    <h1 class="movie_blocks_text_p h1_films_p">О фильме:</h1>
                    <div>
                        <p class="movie_blocks_text_p">
                            {{$data->about}}
                        </p>
                    </div>

                </div>
            </div>
            <div class="movie_blocks_img">
                <div>
                    <img class="movie_blocks_image" src="{{'../img/'.$data->poster}}" alt="{{$data->title}}">
                </div>
                <div class="movie_blocks_hashtag">
                    @include('blocks.tags',  ['id' => $data->id, 'tags' => $tags])
                </div>
            </div>
            <div class="movie_btn_box">
                @auth
                    <div class="movie_btn" onclick="myFunction()">
                        Добавить в списки
                        <div class="movie_drop" id="myDropdown">
                            <div id="film_lists" class="film_lists">
                                @include('blocks.film_lists')
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
        <div class="movie_blocks_range"></div>
        <div class="movie_widget_rating">
            <div class="movie_widget">
                @auth <h2>Как вам фильм?</h2> @endauth
                @guest <h2>Впечатления пользователей:</h2> @endguest
                <div class="movie_widget_icon">
                    @include('blocks.emoji_good', ['id' => $emojis[0]->id, 'isSelected' => $emojis[0]->is_good, 'count' => $emojis[0]->count_good])
                    @include('blocks.emoji_dull', ['id' => $emojis[0]->id, 'isSelected' => $emojis[0]->is_dull, 'count' => $emojis[0]->count_dull])
                    @include('blocks.emoji_scary',['id' => $emojis[0]->id, 'isSelected' => $emojis[0]->is_scary,'count' => $emojis[0]->count_scary])
                    @include('blocks.emoji_sad',  ['id' => $emojis[0]->id, 'isSelected' => $emojis[0]->is_sad,  'count' => $emojis[0]->count_sad])
                    @include('blocks.emoji_fun',  ['id' => $emojis[0]->id, 'isSelected' => $emojis[0]->is_fun,  'count' => $emojis[0]->count_fun])
                </div>
            </div>
            @auth
                <div class="movie_widget movie_rating">
                    <h2>Ваша оценка</h2>
                    <div class="movie_rating_number">
                        @include('blocks.rating_numbers',  ['id' => $data->id, 'rating' => $rating[0]->rating])
                    </div>
                    <div class="movie_rating_number_p">
                        <div>
                            <p>очень плохо</p>
                        </div>
                        <div class="rating_number_p">
                            <p>отлично</p>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
        <section class="movie_aside_widget">
            <div class="movie_information">
                <div class="movie_information_p">
                    <h3>Информация</h3>
                    <div class="movie_information_p">
                        <p>
                            <span class="movie_information_span">Страна</span> <br>
                            {{$data->countries}}
                        </p>
                        <p>
                            <span class="movie_information_span"> Жанр</span> <br>
                            {{$data->genres}}
                        </p>
                        <p>
                            <span class="movie_information_span"> Оригинальное название </span> <br>
                            {{$data->title}}
                        </p>
                        <p>
                            <span class="movie_information_span"> Премьера в мире  </span> <br>
                            {{$data->release_year}}
                        </p>
                    </div>
                </div>
                <div class="movie_information_p box-information_p">
                    <h3>Съёмочная группа</h3>
                    <div class="movie_information_p">
                        <p>
                            <span class="movie_information_span"> Режиссёр  </span> <br>
                            {{$data->directors}}
                        </p>
                        <p>
                            <span class="movie_information_span"> Актёры  </span> <br>
                            {{$data->actors}}
                        </p>
                    </div>
                </div>
                <div>
                    <div class="movie_information_p box-information">
                        <h3>Звук и субтитры</h3>
                        <p>
                            <span class="movie_information_span"> Аудиодорожки </span> <br>
                            Аудиодорожки
                            Русский
                        </p>
                        <p>
                            <span class="movie_information_span">  Качество </span> <br>
                            Качество
                            SD
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
