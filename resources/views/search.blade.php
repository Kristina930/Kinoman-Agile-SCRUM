@extends('layouts.main')

@section('title')
    @parent Поиск
@endsection

@section('pageName')
    @parent Поиск
@endsection

@section('content')
    <main class="content">
        <ul>
            <li class="main_catalog">
                <div>
                    <h2 class="h2-km">Расширенный поиск</h2>
                    <form id="searchForm">
                        <div>
                            <main class="main_box">
                                <h2 class="main_box_h2">Искать фильм:</h2>
                                <div class="main_box_flex">
                                    <div class="main_box_flex_text">
                                        <input type="text" name="searchString" class="main_box_text_input">
                                        <p class="main_box_text_input_p">Полное или частичное название фильма</p>
                                    </div>
                                    <details class="main_box_btn">
                                        <summary class="main_box_btn_summary">Жанры
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="20px"
                                                 height="20px"
                                                 class="main_box_btn_summary_svg">
                                                <path d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75
                                        0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5
                                        32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z"/>
                                            </svg>
                                        </summary>
                                        <div class="main_box_drop">
                                            @forelse($genres as $item)
                                                <label class="main_box_drop_a">
                                                    <input type="checkbox" name="genre_id_{{$item->id}}"
                                                           class="main_box_drop_a_checkbox">
                                                    <p class="main_box_drop_a_p"> {{$item->name}} </p>
                                                </label>
                                            @empty
                                            @endforelse
                                        </div>
                                    </details>
                                    <details class="main_box_btn  box_btn_actors">
                                        <summary class="main_box_btn_summary">Актеры
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="20px"
                                                 height="20px"
                                                 class="main_box_btn_summary_svg">
                                                <path d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75
                                        0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5
                                        32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z"/>
                                            </svg>
                                        </summary>
                                        <div class="main_box_drop box_drop_actors">
                                            @forelse($actors as $item)
                                                <label class="main_box_drop_a">
                                                    <input type="checkbox" name="actor_id_{{$item->id}}"
                                                           class="main_box_drop_a_checkbox">
                                                    <p class="main_box_drop_a_p"> {{$item->firstname}} {{$item->lastname}} </p>
                                                </label>
                                            @empty
                                            @endforelse
                                        </div>
                                    </details>
                                    <details class="main_box_btn">
                                        <summary class="button_year">Годы выхода
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="20px"
                                                 height="20px"
                                                 class="button_year_svg">
                                                <path d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75
                                        0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5
                                        32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z"/>
                                            </svg>
                                        </summary>
                                        <div class="main_box_drop">
                                            @forelse($years as $item)
                                                <label class="main_box_drop_a">
                                                    <input type="checkbox" name="year_id_{{$item['id']}}"
                                                           class="main_box_drop_a_checkbox">
                                                    <p class="main_box_drop_a_p"> {{$item['name']}} </p>
                                                </label>
                                            @empty
                                            @endforelse
                                        </div>
                                    </details>
                                    <button class="main_box_flex_btn" id="submit">Поиск</button>
                                </div>
                            </main>
                        </div>
                    </form>
                </div>
                <div id="search_results">
                    @include('blocks.cards_single', ['data' => $data])
                </div>
            </li>
        </ul>
    </main>
@endsection
