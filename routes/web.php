<?php

use App\Http\Controllers\DogsController;
use Illuminate\Support\Facades\Route;

Route::as('dogs.index')->get('/', [DogsController::class, 'index']);
