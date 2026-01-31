<?php

use App\Http\Controllers\DogsController;
use Illuminate\Support\Facades\Route;

Route::as('dogs.show')->get('/dog/{dogId}', [DogsController::class, 'show']);
Route::as('dogs.index')->get('/', [DogsController::class, 'index']);
