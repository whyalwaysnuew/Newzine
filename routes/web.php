<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

Route::get('/', [FrontController::class, 'index'])->name('front.index');

Route::get('/details/{article_news:slug}', [FrontController::class, 'details'])->name('front.details');

Route::get('/category/{category:slug}', [FrontController::class, 'category'])->name('front.category');

Route::get('/author/{author:slug}', [FrontController::class, 'author'])->name('front.author');

Route::post('/search', [FrontController::class, 'search'])->name('front.search');
