@extends('layouts.main')

@section('title')
    @parent Список профиля
@endsection

@section('pageName')
    @parent Список профиля
@endsection

@section('content')
    @include('blocks.lists', ['data' => $data, 'route' => $route, 'show_list' => true])
    {{$pagination->links("pagination::bootstrap-4")}}
@endsection
