@extends('layouts.main')

@section('title')
    @parent Коллекции
@endsection

@section('pageName')
    @parent Коллекции
@endsection

@section('content')
    @include('blocks.collections', ['$data' => $data, 'route' => $route])
@endsection
