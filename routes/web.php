<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function ()
{
    return view('welcome');
});

//TODO add github link
Route::get('/register', function ()
{
    return view('register');
})->name('register');

Route::get('/login', function ()
{
    return view('login');
})->name('login');

Route::get('/chat', function ()
{
    return view('chat');
})->name('chat');

Route::get('/ollama-test', function ()
{
    return view('ollama-test');
});
