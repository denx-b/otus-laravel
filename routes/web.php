<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Главная
Route::view('/main', 'main');

// Страница регистрации
Route::view('/registration', 'registration');

// Страница пользователя
Route::view('/user', 'user', [
    'name' => 'Иванов Иван',
    'ava' => 'https://www.nicepng.com/png/detail/186-1866063_dicks-out-for-harambe-sample-avatar.png'
]);

// Абстрактная страница
Route::view('/abstract', 'abstract');
