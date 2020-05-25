@extends('layouts.app')

@section('content')
    @push('scripts')
        <script>window.photoList = {!! json_encode($photoList) !!};</script>
    @endpush

    <div class="my-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" @click="openForm = !openForm">Добавить фото</button>
    </div>
    <div v-if="openForm" class="my-3 d-flex">
        <form enctype="multipart/form-data" action="{{ route('photos.create') }}" class="w-100" method="POST">
            @csrf

            <div class="form-group">
                <label for="photo-title">Заголовок</label>
                <input type="text" id="photo-title" class="form-control" name="title" value="">
            </div>

            <div class="form-group">
                <label for="photo-file">Фото</label>
                <input type="file" id="photo-file" class="form-control" name="photo">
            </div>

            <div class="form-group">
                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>

    <div v-else>
        <div v-for="(photo, index) in photoList" class="mb-4">
            <h2 v-text="photo.title"></h2>
            <img :src="photo.src" :alt="photo.title">
            <div>&#128587; <span v-text="photo.login"></span></div>

            <div class="my-3 d-flex justify-content-between">
                <rating v-model="photoList[index]" :type="'photo'" class="mb-3 mb-md-0"></rating>

                <div>
                    <button class="btn" @click="removePhoto(photo.id)">Удалить &#10060;</button>
                </div>
            </div>
        </div>
    </div>

@endsection