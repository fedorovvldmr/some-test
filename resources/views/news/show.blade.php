@extends('layouts.app')

@section('content')

    @push('scripts')
        <script>window.news = {!! json_encode($news) !!}</script>
    @endpush

    <div v-if="openForm" class="my-3 d-flex">
        <news-form :value="news" @input="editNews"></news-form>
    </div>

    <div v-else class="my-3">
        <div v-html="news.text"></div>
        <div>&#128587; <span v-text="news.login"></span></div>
    </div>

    <div class="d-flex justify-content-between flex-column flex-md-row align-items-end my-5">
        <rating v-model="news" :type="'news'" class="mb-3 mb-md-0"></rating>

        <div class="bth-group">
            <button
                    type="button"
                    class="btn"
                    title="Удалить"
                    @click="openForm = !openForm"
            >Редактировать &#9998;
            </button>
            <button
                    type="button"
                    class="btn"
                    title="Удалить"
                    @click="removeNews(news.id, true)"
            >Удалить &#10060;
            </button>
        </div>
    </div>
@endsection