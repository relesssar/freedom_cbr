<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\PageController::class, 'welcome'])->name('welcome');
Route::post('/get-rate', [\App\Http\Controllers\ExchangeController::class, 'rate'])->name('rate');
