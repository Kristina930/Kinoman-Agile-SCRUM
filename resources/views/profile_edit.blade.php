@extends('layouts.main')

@section('title')
    @parent Редактировать профиль
@endsection

@section('pageName')
    @parent Редактировать профиль
@endsection

@section('content')
    @auth
        <div class="position_container">
            <div class="profile_container">
                <form method="POST" action="{{ route('upload_user_image') }}" enctype="multipart/form-data"
                      class="profile_edit_form ">
                    @csrf
                    <div>
                        <img class="user_img"
                             @empty($user->image_path) src="../img/userfoto.svg" @endempty
                             @isset($user->image_path) src="{{$user->image_path}}" @endisset
                        >
                    </div>
                    <div class="profile_photo">
                        <div class="row mb-0">
                            <h2 class="profile_photo_h2">Обновить фотографию</h2>
                            <div class="col-md-8 offset-md-1 ">
                                <div class="custom-file">
                                    <input type="file" name="user_image"
                                           class="form-control user_image_input profile_photo_input"
                                           id="chooseFile">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn_km_download btn-primary_km btn-km">
                                    <p class="">{{ __('Загрузить') }}</p>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="user_info box_profile_user">
            <form method="POST" action="{{ route('profile_update') }}" class="profile_edit_form">
                @csrf
                <div>
                    <div class="row mb-4">
                        <label for="name"
                               class="col-md-4 col-form-label text-md-end text-form-km">{{ __('Имя:') }}</label>
                        <div class="col-md-8">
                            <input id="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ $user->name }}" required autocomplete="name"
                                   autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="email"
                               class="col-md-4 col-form-label text-md-end text-form-km">{{ __('Email адрес:') }}</label>
                        <div class="col-md-8">
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ $user->email }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4 ">
                        <div class="col-md-8 offset-md-4-label">
                            <div class="form-check ">
                                <input class="form-check-input text-form-km" type="checkbox" name="show_public"
                                       id="show_public" {{ $user->show_public ? 'checked' : '' }}>
                                <label class="form-check-label text-form-km profile_edit_label" for="show_public">
                                    {{ __('Показывать профиль всем') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row mb-4 offset-md-4">
                            <div class="update_btn">
                                <button type="submit" class="btn btn-primary btn-km">
                                    <p>{{ __('Обновить') }}</p>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endauth
@endsection
