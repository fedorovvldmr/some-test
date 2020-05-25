<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>

    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>
<body>
<div id="app">
    <b-navbar type="dark" variant="info">
        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
                @if (\Illuminate\Support\Facades\Auth::check())
                    <li class="nav-item">
                        <a class="nav-link">&#128587; {{ $user->name }}</a>
                    </li>
                @endif

                <b-nav-item href="{{ route('news') }}">Новости</b-nav-item>
                <b-nav-item href="{{ route('photos') }}">Фото</b-nav-item>

                @if (\Illuminate\Support\Facades\Auth::check())
                    <li class="nav-item">
                        <form class="form-inline" action="{{ route('logout') }}" method="POST">
                            @csrf

                            <button class="btn nav-item">Выход</button>
                        </form>
                    </li>
                @endif
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>

    <div class="container my-5">
        <h1 class="mb-4" v-text="title"></h1>

        @yield('content')
    </div>
</div>

@push('scripts')
    <script>
        window.title = '{{ $title ?? '' }}';
        window.user  = '{{ $user->name ?? '' }}';
    </script>
@endpush

@stack('scripts')
<script src="{{ asset('/js/app.js') }}" async></script>
</body>
</html>