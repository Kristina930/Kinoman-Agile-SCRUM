@extends('layouts.main')

@section('title')
    @parent Киноман
@endsection

@section('pageName')
    @parent Киноман
@endsection

@section('content')
    <div class="header_logo">
        <img src="/img/logo.svg" alt="logo" class="home_logo_img">
        <p class="home_logo_p">Киноман</p>
        <p class="home_about">
            Проект «Киноман» — это интернет-сервис о кино с личным кабинетом и публичным профилем пользователя,
            многофункциональным поиском и подбором фильмов и сериалов по жанрам, актерам и годам.
            Зарегистрированные пользователи могут добавлять фильмы в избранное, выставлять им оценки, присваивать теги,
            составлять тематические коллекции и делиться ими со всеми желающими.
        </p>
    </div>
@endsection
