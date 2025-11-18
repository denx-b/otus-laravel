@extends('layout.main')

@section('content')

    <h1>Reg page</h1>

    <div class="card shadow-sm" style="max-width: 360px;">
        <div class="card-body">
            <h2 class="h4 text-center mb-4">Регистрация</h2>

            <form action="#" method="post">
                <div class="mb-3">
                    <label class="form-label">Имя</label>
                    <input type="text" class="form-control" placeholder="Введите имя" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Введите email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Пароль</label>
                    <input type="password" class="form-control" placeholder="Введите пароль" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Создать аккаунт
                </button>
            </form>
        </div>
    </div>

@endsection
