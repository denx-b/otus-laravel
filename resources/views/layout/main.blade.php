@extends('layout.root')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
@endsection

@section('body')
    <header class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-2 my-2">
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a @class(['nav-link' => true, 'active' => request()->is('main')]) href="/main">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link' => true, 'active' => request()->is('user')]) href="/user">Пользователь</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link' => true, 'active' => request()->is('registration')]) href="/registration">Регистрация</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link' => true, 'active' => request()->is('abstract')]) href="/abstract">Абстрактная</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <section class="container">
        @yield('content')
    </section>
@endsection
