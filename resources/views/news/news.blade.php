@extends('layouts.app')

@section('content')
    @push('scripts')
        <script>window.newsList = {!! json_encode($newsList) !!};</script>
    @endpush

    <div class="my-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" @click="openForm = !openForm">Добавить новость</button>
    </div>
    <div v-if="openForm" class="my-3 d-flex">
        <news-form :value="news" @input="createNews"></news-form>
    </div>

    <ul class="list-group">
        <li v-for="news in newsList" class="list-group-item d-flex justify-content-between align-items-center">
            <a :href="'/news/' + news.id" v-text="news.title"></a>

            <div class="ml-3 d-flex d-flex justify-content-between align-items-center">
                <div>рейтинг: <b v-text="news.rating"></b></div>

                <button class="btn btn-sm ml-3" title="Удалить" @click="removeNews(news.id)">&#10060;</button>
            </div>
        </li>
    </ul>

@endsection