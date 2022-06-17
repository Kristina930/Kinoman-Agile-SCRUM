@extends('layouts.main')

@section('title')
    @parent Каталог
@endsection

@section('pageName')
    @parent Каталог
@endsection

@section('content')
    <main class="content">
        <ul>
            <li class="main_catalog">
                <h2 class="h2-km">Каталог</h2>
                @include('blocks.cards_single', ['data' => $data])
            </li>

            {{$data->links("pagination::bootstrap-4")}}
        </ul>
    </main>
@endsection
